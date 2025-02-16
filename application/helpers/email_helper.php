<?php defined('BASEPATH') or exit('No direct script access allowed');

function send_email($from, $fromName, $email, $subject, $message) 
{
    $ci = & get_instance();

    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'ithelpdesk.lbe@gmail.com',
        'smtp_pass' => 'LBEhelpdesk',
        'mailtype'  => 'html',
        'charset'   => 'iso-8859-1'
    );

    $ci->load->library('email', $config);

    $ci->email->from($from, $fromName);
    $ci->email->set_newline("\r\n");
    $ci->email->to($email);

    $ci->email->subject($subject);
    $ci->email->message($message);

    $ci->email->send();
}