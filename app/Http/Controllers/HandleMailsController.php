<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions;
use Illuminate\Support\Facades\Log;
use App\Models\Prospecto;

class HandleMailsController extends Controller
{
    public static function getAllMails(){
        try {
            $incoming_mail_server = env('IMAP_SERVER_CONNECTION');
            $email = env('IMAP_ADDRESS');
            $password = env('IMAP_PASSWORD');

            $mbox = imap_open($incoming_mail_server, $email , $password ) or die("can't connect: " . imap_last_error());
            $num = imap_num_msg($mbox); // read total messages in email

            $email = imap_fetchbody($mbox,$num,1.1); // 1.1 lee text/plain solamente, 1.2 lee text/html y 1 lee todo
            $email_attachment = imap_fetchbody($mbox,$num,2); //2 lee el archivo para correos con attachment mime
            $structure = imap_fetchstructure($mbox, $num);

            function get_string_between($string, $start, $end){
                $string = ' ' . $string;
                $ini = strpos($string, $start);
                if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                return substr($string, $ini, $len);
            }

            $new_prospect_name = get_string_between($email, 'Name', 'Level (Seniority in the IT Industry)');
            //echo $new_prospect_name;
            $seniority = get_string_between($email, 'Level (Seniority in the IT Industry)', 'Location');
            //echo $seniority;
            $disponibility = get_string_between($email, 'Interview availability', 'Visa & Passport');
            //echo $disponibility;
            $email_attachment = base64_decode($email_attachment);


            $curriculum = get_object_vars($structure->parts[1]);
            $curriculum_name = $curriculum['description'];
            $file_extention = $curriculum['subtype'];

            imap_expunge($mbox);
            imap_close($mbox);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        try {
            $file_name = $curriculum_name;

            $find_prospect = Prospecto::where('name', $new_prospect_name)->first();
            if ($find_prospect) {
                echo "ya existe, ya se envio notificacion";
            } else {
                $prospect = Prospecto::create([
                    'name' => $new_prospect_name,
                    'seniority' => $seniority,
                    'disponibility' => $disponibility,
                    'curriculum_filename' => $curriculum_name
                ]);
                Storage::disk('local')->append('Ejemplo.txt', $email);
                $path = Storage::disk('s3')->put($file_name, $email_attachment);
                $path = Storage::disk('s3')->url($path);
                echo "curriculum guardado";
        }
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
}
