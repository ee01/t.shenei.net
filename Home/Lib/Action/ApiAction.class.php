<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ApiAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ApiAction extends Action {

    public function userpreview() {
        $uid=$_GET['uid'];
        $class=$_GET['class'];

        $user = D('Users')->field('nickname,user_head,user_auth,lastcontent,lastconttime')->where("user_id='$uid'")->find();
        $time=$user['lastconttime']?timeop($user['lastconttime']):"";

        echo '<div class="'.$class.'"></div><table border="0" cellpadding="0" cellspacing="0"><tr><td width="55" rowspan="2" valign="top"><img src="'.sethead($user['user_head']).'" width="48px" style="border:1px solid #999"/></td><td valign="top"><span class="'.setvip($user['user_auth']).'">'.$user['nickname'].'</span>：'.simplecontent($user['lastcontent']).'</td></tr><tr><td valign="top" class="followtime">'.$time."</td></tr></table>";
        exit;
    }

    public function senMail($title,$send,$sendto) {
        //标题防止乱码
        $title = iconv("utf-8", "gbk",$title);
        $title = "=?GB2312?B?".base64_encode($title)."?=";

        if ($this->site['mail_mode']==1) {
            import("@.ORG.mail.phpmailer");
            $phpmailer=new PHPMailer();
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth   = true;
            $phpmailer->IsHTML(true);
            $phpmailer->Host       = $this->site['smtp_host'];
            $phpmailer->Port       = $this->site['smtp_port'];
            $phpmailer->Username   = $this->site['smtp_user'];
            $phpmailer->Password   = $this->site['smtp_pass'];
            $phpmailer->SetFrom($this->site['smtp_user'], $this->site['sitename']);
            $phpmailer->AddReplyTo($this->site['smtp_user'], $this->site['sitename']);
            $phpmailer->CharSet    = "utf8";
            $phpmailer->Subject    = $title;
            $phpmailer->AltBody    = "要查看邮件，请使用HTML兼容的电子邮件软件!";
            $phpmailer->MsgHTML($send);
            $mails=explode(',',$sendto);
            foreach ($mails as $key=>$val) {
                $phpmailer->AddAddress($val);
            }
            $phpmailer->Send();
        } else {
            import("@.ORG.mail");
            $mail=new Email();
            $mail->setTo($send);
            $mail->setFrom($this->site['servicemail']);
            $mail->setSubject($title);
            $mail->setHTML($send);
            $mail->send();
        }

    }
}
?>