<?php
namespace App\Http\Controllers\Api\Member\Controllers;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberInterface;
use App\Http\Controllers\Api\Member\Repositories\MemberSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller{
    const MOBILE = 'mobile';
    const EMAIL = 'email';
    const MXU = 'mxu';
    const WEB = 'web';
    const WECHAT = 'wechat';
    const QQ = 'qq';
    const SINA = 'sina';
    const REGISTER = 'register';
    const OPEN_CLIENT = 'open_client';
    const UPLOAD_AVATAR = 'upload_avatar';
    const RESET_PASSWORD = 'reset_password';
    const BIND = 'bind';
    const LOGIN = 'login';
    const UPDATE = 'update';
    
    private $member;
    private $sms;
    private $setting;
    public function __construct(MemberInterface $member,MemberSetting $setting)
    {
        $this->member = $member;
        $this->setting = $setting;
        
    }
    
    public function register(Request $request){
        
          // TODO 检查黑名单，ip限制，设备号限制，为了防止刷会员  如果是网页端登录 包含email tel name 登录必须要密码
        if (!$member_name = trim($request->get('member_name'))) {
            return response()->error(10001, 'Member Name Required');
        }
        if (!$type = $request->get('type')) {
            return response()->error(10000, 'Not Type');
        }
        if (!in_array($type, ['wechat', 'qq']) && !$password = $request->get('password')) {
            return response()->error(10002, 'Password Required');
        }
        
        // 检查类型
        switch ($type) {
            case 'mobile':
                $type                = $data['type'] = self::MOBILE;
                $type_name           = trans('text.Mobile Login');
                $member_name         = verify_mobile($member_name) ? $member_name : false;
                $mobile_nick_name    = $member_name;
                $data['member_name'] = $data['mobile'] = $member_name;
                $settings            = $this->setting->getSetting($type);
                break;
            case 'wechat':
                $type                = $data['type'] = self::WECHAT;
                $type_name           = trans('text.Wechat Login');
                $platform_id         = trim($request->get('platform_id'));
                $wx_platform_id      = $platform_id;
                $member_name         = $wx_platform_id;
                $data['member_name'] = trim($request->get('member_name'));
                $data['nick_name']   = $data['member_name'];
                $settings            = $this->setting->getSetting($type);
                break;
            case 'qq':
                $type                = $data['type'] = self::QQ;
                $type_name           = trans('text.QQ Login');
                $platform_id         = trim($request->get('platform_id'));
                $qq_platform_id      = $platform_id;
                $member_name         = $qq_platform_id;
                $data['member_name'] = trim($request->get('member_name'));
                $data['nick_name']   = $data['member_name'];
                $settings            = $this->setting->getSetting($type);
                break;
            case 'web':
                $type                    = $data['type'] = self::WEB;
                $type_name               = trans('text.Web Login');
                $data['member_name']     = $member_name;
                $data['nick_name']       = $data['member_name'];
                $data['reg_device_type'] = self::WEB;
                break;
            default:
                $type                    = $data['type'] = self::MXU;
                $type_name               = trans('text.MXU Login');
                $data['member_name']     = $member_name;
                $data['nick_name']       = $data['member_name'];
                $data['reg_device_type'] = self::MXU;
                break;
        }
        if (!isset($settings['is_register']) || !$settings['is_register']) {
            return response()->error(10008, 'Not Registered');
        }
        if (!in_array($type, ['wechat', 'qq', 'sina']) && $this->member->checkMemberName($member_name)) {
            return response()->error(10011, 'Member Name Exists');
        }
        if (isset($password)) {
            $data['password'] = bcrypt($password);
        }
        // 检查手机号和验证码是否存在
        if ($type == self::MOBILE) {
            if ($this->member->getMemberByMobile($member_name)) {
                return response()->error(10011, 'Mobile Bind Exists');
            }
            // TODO 检测是否需要验证码
            $code = $request->get('verifycode');
            if (!$code) {
                return response()->error(10012, 'Code Required');
            }
            if (!$this->sms->checkVerifyCode($member_name, $code)) {
                return response()->error(10013, 'Verify Code Wrong');
            }
            if (!$password = trim($request->get('password'))) {
                return response()->error(10014, 'Password Required');
            }
            $data['nick_name'] = isset($mobile_nick_name) ? $mobile_nick_name : $member_name;
        }
    
        // 检查手机.微信等绑定是否存在
        if ($this->member->checkBind($member_name, $type)) {
            return response()->error(10015, 'Member Name Bind Exists');
        }
    
        // 个推推送设备号
        $data['push_device']     = trim($request->get('push_device'));
        $data['reg_device_type'] = isset($data['reg_device_type']) ? $data['reg_device_type'] : trim($request->get('device_type'));
        $data['reg_device']      = trim($request->get('device_token'));
        $data['ip']              = request()->getClientIp();
    
        // 创建会员
        if (!$member = $this->member->createMember($data)) {
            return response()->error(10016, 'Member Create Failed');
        }
    
        // 第三方头像
        if ($avatar_url = trim($request->get('avatar_url'))) {
            $avatar = Scissor::upload($avatar_url);
            if (isset($avatar['key']) && $avatar['key']) {
                $update_avatar = $member->update(['avatar' => $avatar['key']]);
                if ($update_avatar) {
                    // 第一次上传头像加积分
                    event('addCredit', [['member_id' => $member->id, 'type' => self::UPLOAD_AVATAR]]);
                }
            }
        }
        
    }
    
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function login(Request $request){
        $type        = trim($request->get('type'));
        $platform_id = trim($request->get('platform_id'));
       
        if ($type && $platform_id) {
            // 第三方登录
            // 微信等绑定是否存在
            if (!$this->member->checkBind($platform_id, $type)) {
                // 不存在去注册 (返回member_id)
                $bind_id = $this->register($request);
            } else {
                $bind    = $this->member->getBindInfoByPlatform($platform_id, $type);
                $bind_id = $bind->member_id;
            }
            // 登录
            if (!$member = $this->member->getMemberById($bind_id)) {
                return response()->error(10002, 'Member Info Not Found');
            }
            $member_name = $member->member_name;
            $token       = JWTAuth::fromUser($member);
        } else {
            // 其他登录
            if (!$member_name = trim($request->get('member_name'))) {
                return response()->error(10001, 'Member Name Required');
            }
            if (!$credentials['password'] = trim($request->get('password'))) {
                return response()->error(10004, 'Password Required');
            }
    
           
            if (verify_mobile($member_name)) {
                // 验证是否允许手机登录
                $settings = $this->setting->getSetting(self::MOBILE);
                if (!isset($settings['is_login']) || !$settings['is_login']) {
                    return response()->error(10001, 'Login Closed');
                }
                $credentials['mobile'] = $member['mobile'] = $member_name;
            } elseif (verify_email($member_name)) {
                $credentials['email'] = $member['email'] = $member_name;
            } else {
                $credentials['member_name'] = $member['member_name'] = $member_name;
            }
            try {
                // attempt to verify the credentials and create a token for the user
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->error(10006, 'Login Failed');
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->error(10007, 'Login Failed');
            }
            if (!$member = $this->member->getMember($member)) {
                return response()->error(10005, 'Member Info Not Found');
            }
        }
        
    }
}