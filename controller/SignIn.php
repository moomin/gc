<?php

require_once 'Controller.php';
require_once 'openid.php';
require_once 'User.php';

class SignIn extends ControllerBase
{
    public function __construct()
    {
    }

    public function isValid()
    {
        if ((!isset($this->post['openid_identifier']) || '' == $this->post['openid_identifier']) &&
            !isset($this->args['openid_mode']))
        {
            return false;
        }

        return true;
    }

    public function index()
    {
        if (!$this->isValid())
        {
            return false;
        }

        try
        {
            if(isset($this->post['openid_identifier']))
            {
                $id = $this->post['openid_identifier'];
                $id .= substr($id, 0, 4) != 'http' ? 'http://' : '';
                
                $openid = new LightOpenID;
                $openid->identity = $this->post['openid_identifier'];
                header('Location: ' . $openid->authUrl());
                exit(0);
            }
            else
            {
                $openid = new LightOpenID;

                $user = Site::getInstance()->user;

                if ($this->args['openid_mode'] == 'cancel')
                {
                    $user->setAuthResult(User::AUTH_RES_CANCEL);
                }
                elseif ($openid->validate())
                {
                    $user->signIn($openid->identity);

                    //destroy any current session
                    if (session_id())
                    {
                        unset($_SESSION);
                        session_destroy();
                        session_write_close();
                    }

                    session_start();
                    $_SESSION['user'] = $user->name;
                    session_write_close();
                    header('Location: ' . Site::getInstance()->getUrl('index', '', array(), true));
                    exit(0);
                }
                else
                {
                    $user->setAuthResult(User::AUTH_RES_FAIL);
                }

                return false;
            }
        }
        catch (ErrorException $e)
        {
            throw $e;
        }
        
        return true;
    }
}
