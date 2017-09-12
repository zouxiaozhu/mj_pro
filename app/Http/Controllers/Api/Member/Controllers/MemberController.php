<?php
namespace App\Http\Controllers\Api\Member\Controllers;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberInterface;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberSMSInterface;
use App\Http\Controllers\Api\Member\Repositories\MemberSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Member\Models\MemberSMS;
use Tymon\JWTAuth\Facades\JWTAuth;
class MemberController extends Controller{
    const MOBILE = 'mobile';
    const EMAIL = 'email';
    const MJ = 'mj';
    const WEB = 'web';
    const WECHAT = 'wechat';
    const QQ = 'qq';
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
    public function __construct(MemberInterface $member,MemberSetting $setting,MemberSMSInterface $sms)
    {
        $this->member = $member;
        $this->setting = $setting;
        $this->sms= $sms;
        
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
                $settings            = $this->setting->getSetting($type);
                break;
            default:
                $type                    = $data['type'] = self::MXU;
                $type_name               = trans('text.MXU Login');
                $data['member_name']     = $member_name;
                $data['nick_name']       = $data['member_name'];
                $data['reg_device_type'] = self::MJ;
                $settings            = $this->setting->getSetting($type);
                break;
        }

        if (!isset($settings['is_register']) || !$settings['is_register']) {
            return response()->error(10008, 'Not Registered');
        }
        if (!in_array($type, ['wechat', 'qq']) && $this->member->checkMemberName($member_name)) {
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
// $this->sms->checkVerifyCode($member_name, $code)
            if (!1) {
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

             //Scissor::upload($avatar_url);
            if (isset($avatar['key']) && $avatar['key']) {
                $update_avatar = $member->update(['avatar' => $avatar['key']]);
                if ($update_avatar) {
                    // 第一次上传头像加积分
//                    event('addCredit', [['member_id' => $member->id, 'type' => self::UPLOAD_AVATAR]]);
                }
            }
        }
        
        $bind = [
            'member_id'         => $member->id,
            'platform_id'       => $member_name,
            'third_name'        => isset($platform_id) ? $data['member_name'] : "",
            'avatar_url'        => isset($avatar_url) ? $avatar_url : "",
            'bind_device_token' => isset($data['reg_device']) ? $data['reg_device'] : '',
            'type'              => $data['type'],
            'type_name'         => $type_name,
            'ip'                => request()->getClientIp(),
        ];
        if (!$bind = $this->member->createBind($bind)) {
            return response()->error(10017, 'Member Name Bind Failed');
        }

        // 删除验证码
        if (!isset($platform_id)) {
           // $this->sms->deleteVerifyCode($member_name);
        }
        // 会员操作记录
        $trace = [
            'member_id'    => $member->id,
            'member_name'  => isset($platform_id) ? $data['member_name'] : $member_name,
            'type'         => self::REGISTER,
            'type_name'    => trans('text.Member Register'),
            'ip'           => request()->getClientIp(),
            'device_token' => isset($data['reg_device']) ? $data['reg_device'] : '',
        ];
//        event('addTrace', [$trace]);
//        // 添加注册积分
//        event('addCredit', [['member_id' => $member->id, 'type' => self::REGISTER]]);
//        // 登录积分
//        event('addCredit', [['member_id' => $member->id, 'type' => self::LOGIN]]);
        // 会员扩展信息
        $extension = [
            'province'  => trim($request->get('province')),
            'city'      => trim($request->get('city')),
            'dist'      => trim($request->get('dist')),
            'detail'    => trim($request->get('detail')),
            'qq'        => trim($request->get('qq')),
            'wechat'    => trim($request->get('wechat')),
            'birthday'  => trim($request->get('birthday')),
            'gender'    => trim($request->get('gender')),
            'member_id' => $member->id,
        ];
        $this->member->createMemberInfo($extension);
        // TODO 用户注册统计
        $token = JWTAuth::fromUser($member);

        return response()->success(['token' => $token]);
    }
    

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

                $credentials['member_name'] = $member['mobile'] = $member_name;
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
        
        // 个推推送设备号
        $data['last_push_device']       = trim($request->get('push_device'));
        $data['last_login_device_type'] = trim($request->get('device_type'));
        $data['last_login_device']      = trim($request->get('device_token'));
        $data['last_login_ip']          = request()->getClientIp();
        $data['last_login_time']        = TIMENOW;
        $member->update($data);

        // 会员操作记录
        $trace = [
            'member_id'    => $member->id,
            'member_name'  => $member_name,
            'type'         => self::LOGIN,
            'type_name'    => trans('text.Member Login'),
            'ip'           => request()->getClientIp(),
            'device_token' => trim($request->get('device_token')),
        ];
        event('addTrace', [$trace]);
        // 登录积分
        event('addCredit', [['member_id' => $member->id, 'type' => self::LOGIN]]);
        // 第一次使用APP登录积分
        if (isset($data['last_push_device']) && $data['last_push_device']) {
            event('addCredit', [['member_id' => $member->id, 'type' => self::OPEN_CLIENT]]);
        }

        return response()->success(['token' => $token]);

    }
}