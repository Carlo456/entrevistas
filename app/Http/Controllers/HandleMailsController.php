<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class HandleMailsController extends Controller
{
    public static function getAllMails(){
        $incoming_mail_server = env('MAIL_SERVER_CONNECTION');
        //$incoming_mail_server = "{imap.gmail.com:993/imap/ssl}INBOX";
        //$incoming_mail_server = '{https%3A%2F%2Foutlook.office.com%2FIMAP.AccessAsUser.All%20https%3A%2F%2Foutlook.office.com%2FPOP.AccessAsUser.All%20https%3A%2F%2Foutlook.office.com%2FSMTP.Send%20offline_access%20openId%20email}INBOX';
        //$incoming_mail_server = '{outlook.office365.com:993/tls}';

        $your_email = env('MAIL_ADDRESS'); // your outlook email ID
        $yourpassword = env('MAIL_PASSWORD'); // your outlook email password
        $mbox =imap_open($incoming_mail_server, $your_email, $yourpassword);
        //$mbox = imap_open($incoming_mail_server, $your_email , $yourpassword ) or die("can't connect: " . imap_last_error());
        $num = imap_num_msg($mbox); // read total messages in email
        $MC = imap_check($mbox);

        $output = "";

        //$emails = imap_search($mbox,'ALL');


        $email = imap_fetchbody($mbox,$num,1);
        $output .= $email;

        /*
        foreach($emails as $email){
            $headerInfo = imap_headerinfo($mbox,$email);

            $output .= $headerInfo->subject.'<br/>';
            $output .= $headerInfo->toaddress.'<br/>';
            $output .= $headerInfo->date.'<br/>';
            $output .= $headerInfo->fromaddress.'<br/>';
            //$output .= $headerInfo->reply_toaddress.'<br/>';

            $emailStructure = imap_fetchstructure($mbox,$email);

            if(!isset($emailStructure->parts)) {
                $output .= imap_qprint(imap_body($mbox, $email, FT_PEEK));
            } else {
                //
            }
        echo $output;
        }

        /* ------------------------------------------------------------------- */
        /*
        $msg=array();
  // Fetch an overview for all messages in INBOX
        $result = imap_fetch_overview($mbox,"$num:{$MC->Nmsgs}",0);
        foreach ($result as $overview) {
            echo 'Message no'.$overview->msgno. '<br/>';
                    "{$overview->subject}<br/>";
            $check = imap_mailboxmsginfo($mbox);

        echo $check->Unread;

        echo $overview->subject;
        echo imap_body($mbox, $overview->msgno);

    //code to check and display email received from a particular Email address
        if(preg_match("/carlo.valenzuela@improving.com.mx/",$overview->from,$match)){
              $msg[$overview->msgno]=$overview->subject;
              imap_delete($mbox,$overview->msgno);
        } else {
              imap_delete($mbox,$overview->msgno);
        }

        }

        */
        //imap_expunge($mbox);
        echo $output;
        imap_close($mbox);

        $num_random = rand(1,1000);
        $nombre = "Ejemplo.txt";
        Storage::disk('local')->append($nombre, $output);
    }

    public static function monitorearCorreo(){

        $num_random = rand(1,1000);
        $nombre = "Ejemplo.txt";
        Storage::disk('local')->append($nombre, "Content no $num_random\n");
    }


}
