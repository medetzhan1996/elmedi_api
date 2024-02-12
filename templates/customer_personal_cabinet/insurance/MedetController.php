<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
Use App\Disease_history;
Use App\Schedule_doctor;
use App\User;
use App\Department_adaptive_marker;
use File;
use App\Pacients;
use App\Pacient_services;
use App\Departments;
use App\Receptions;
use OpenTok\OpenTok;
use App\PreparatBalance;
use App\ListPreparats;
use App\AppPacients;
Use App\Bg;
Use App\Sur;
Use App\AppData;
Use App\AppIntegrateMis;
Use App\Forms;
Use App\Rows;
Use App\Markers;
Use App\Forms_group;
Use App\Hospital_forms;
Use App\Insurance;
use App\Department_forms;
use Validator;
use Auth;

class MedetController extends Controller
{
  public function index2(Request $request){
    $clients = [
      'Елікбай Арсен Маратұлы',
        'Есқуатова Аяжан Алекенқызы',
        'Сулайманова Перизат Нуржанқизи',
        'Айтқазы Заңғар Талғатұлы',
        'Ғибадатқызы Нұрай',
        'Тұрар Мадина Хамитқызы',
        'Ануарбек Ақниет Алтынбекқызы',
        'Онгарбаева Көркемай Мухтарқызы',
        'Жалғасбай Аякөз Аманкелдіқызы',
        'Мұхит Саят Тайырұлы',
        'Қабдешов Толағай Алмазұлы',
        'Керімқұл Мөлдір Нұрпейісқызы',
        'Ынтымақ Рыскелді Серікбайұлы',
        'Сәлім Нұрқанат Елтайұлы',
        'Валихан Ерсұлтан Маралбекұлы',
        'Рахмидин Назерке Берстенқызы',
        'Калиев Данияр Исаханович',
        'Ташбаев Огабек Хабибуллаевич',
        'Наурызбаева Мерует Жасұланқызы',
        'Қонысбаева Аружан Қашақбайқызы',
        'Қалила Аружан Әмірханқызы',
        'Ергенбек Самғар',
        'Абдулатипов Абдубосит Жумадуллоұлы',
        'Манабов Мадияр Жұмағазыұлы',
        'Кабиденов Ерболат Какенович',
        'Ауған Аружан Аязханқызы',
        'Жолдасбек Ерасыл Үсенұлы',
        'Юнусов Иззат Талғатұлы',
        'Төралықызы Еңлік',
        'Абу Нұрлыбек Ержанұлы',
        'Пердебай Айтбай Ержанұлы',
        'Манарбеков Калыбек Болатбекович',
        'Айтбаев Санжар Азаматович',
        'Берекет Дияс Бақтұлы',
        'Саидикулов Жавохир Жахонгирулы',
        'Ерлан Қажмұқан',
        'Тулеубаев Ерсултан Едилулы',
        'Беделбай Ділназ Бахытбекқызы',
        'Құттыбай Әселхан Нұрғалиқызы',
        'Тайырұлы Иманғали',
        'Иван Абылай Асханұлы',
        'Турбеков Ержан Нурланович',
        'Жаханов Нурсултан Толыбайұлы',
        'Срабаева Жансая Жүсіпқызы',
        'Куанханова Ақерке Бауыржанқызы',
        'Жапарбаева Венера Омаровна',
        'Абдыкенов Ансар Жалынұлы',
        'Тоғызбай Назерке Берікболқызы',
        'Тоқтасын Жұлдыз Талғатқызы',
        'Разакбай Жансая Сабитқызы'
    ];

    $rpn_token = AppData::get_token();
    #$rpn_token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4MDU3MzMwIiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODA1NzMyOSwiZXhwIjoxNjY4MTE0OTI5LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.gp6Tdb3imoT0O2Hcfm3BMB2_Vdic5thWJTuhbm58pz3pzLAgrwPTRI8zjEpIemYHyvGO0m9Lai0CAke1Gc861Qjsqv4Bo-2XDG5AJvwRBjzYHK1eaPD4ALYsHrgHG-gM44VfoEvVJZ4-HzHcSmaHlKtvK4IKFBC_AWpo0Hn_T-xFSns8MBRetFneB1bWAZKuQgTvcKA3XFKmaAw2vX9roScyM0X8-lfbIBbVuiXkuhOlp-cWMtYsRiRhs234un8K2hm_WvTsjn0N76Ur4ZOnYuwiuEaC6dQ-zrsZOn080PDNr3uJIS8ZCeZWZTVm8BnIulZfjnUjOZFBN2r5OU3W6g';
    foreach($clients as $client){
      $clientnew = str_replace(' ', '%20', $client);
      $getPatientData = AppData::getPatientDiplom($clientnew,$rpn_token);
      $json_data = json_decode($getPatientData)[0] ?? [];
      $iin=$json_data->iin??'';
      echo $client .'  '.$iin. "\n\n";
    }
    exit();
    // Добавить расписания доктора  мынау -------------------------------------
    $authurl = "http://82.200.165.222:1228/api/customer_insurance/get_visits";
    $headers = array();
    $headers['Authorization'] = "Basic ";
    $headers['Content-Type'] = "application/x-www-form-urlencoded";
	  $services = DB::table('services_limit')->where(['parent_id'=>0, 'status'=>'Выполнен'])
		  ->whereDate('date', '>=', '2022-06-26')
		  ->orderBy('date')->get();
    foreach($services as $service){
		  $pacient_id = DB::table('pacients')->where('iin', $service->patient_iin)->first()->id; 
      $pacients=new Pacients($pacient_id);
		  $service_title = DB::table('mediker_services')->find($service->service_id)->name??'';
		  $service_code = DB::table('mediker_services')->find($service->service_id)->code??'';
		  $doctor = DB::table('users')->find($service->doctor_id)->name??'';
		  $price = DB::table('price_service')->where('service_id', $service->service_id)->first()->implement_insurance_price??'-';
		  $mkb = DB::table('mkb_10')->find($service->mkb_id)->mkb_code??'';
		  $data = array(
  			'iin'           => $service->patient_iin,
  			'fullname'      => $pacients->get_full_name(),
  			'date'          => date('Y-m-d', strtotime($service->date)),
  			'time'          => date('H:i:s', strtotime($service->date)),
  			'doctor'        => $doctor,
  			'service_title' => $service_title,
  			'service_code'  => $service_code,
  			'service_price' => strval($price),
  			'doctor_iin'    => '-',
  			'mkb10'         => $mkb
		  );
  		$ch = curl_init();
  		curl_setopt($ch, CURLOPT_URL, $authurl);
  		curl_setopt($ch, CURLOPT_POST, 1 );
  		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		curl_setopt($ch, CURLOPT_USERPWD, "medet:dostar1996");
  		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  		$result = curl_exec( $ch );
  		if(json_decode($result)){
  			echo $result;
  		}
	 }
    /* -------------------------------------------------------------------------- */
    //return 'test';
  	// Получить токен    
  }
  public function pdf_direct(Request $request){
    $form_mkb10_eps = DB::table('form_mkb10_eps')->where('mkb10', 'like', 'I%')->whereNull('info')->whereNotNull('history_id')->whereNotNull('mkb10')->limit(10)->get();
    $icd_type = 0;
    $direction_reason = 7;
    $sended_mo = 400000000000006;
    $sending_mo = 400000000000006;
    $paymentType = 2;
    $fin_source = 73;
    $access_token = AppIntegrateMis::get_token();
    $rpn_token = AppData::get_token();
    foreach ($form_mkb10_eps as $key => $value) {
      
      $mkb10 = $value->mkb10;
      $iin = $value->pacient_iin;
      if($iin){
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $user = auth()->user();
        $getPatientData = AppData::getPatientData($iin,$rpn_token);  
        $patientData=json_decode($getPatientData);
        $rpn_id=$patientData->rpn_id??''; 
        $lastName=$patientData->lastName??''; 
        $firstName=$patientData->first_name??''; 
        $secondName=$patientData->surname??'';
        $sex=$patientData->sex??'1';
        $birthDate=$patientData->birthDate??'';

          
        $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
        $options = array(
                    'cache_wsdl' => 0,
                    'trace' => 1,
                    'stream_context' => stream_context_create(
                          array(
                          'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                              'allow_self_signed' => true
                            )
                        ))
                    );
        if($paymentType==3):
          $ServiceCDSKind=1800;
        elseif($paymentType==1):
          $ServiceCDSKind=1400;
        else:
          $ServiceCDSKind=1900;
        endif;
        $customer=400000000000006;
        $performer=400000000000006;
        $id=rand(10,9000000);
        while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
          $id=rand(10,9000000);
        }
        $doctorPostId=0;
        $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
        $client = new \SoapClient($ftp_server,$options); 
        $Services=array(
          'ID'=>$id,
          'Date'=>$executedServiceDate,
          'Customer'=>$customer,
          'Performer'=>$performer,
          'CustomerDepartament'=>0,
          'PerformerDepartament'=>0,
          'CustomerEmployee'=>$doctorPostId,
          'PerformerEmployee'=>0,
          'ServiceID'=>0,                       
          'PatientFirstName'=>$firstName,
          'PatientLastName'=>$lastName,
          'PatientMiddleName'=>$secondName,
          'PatientSexID'=>$sex,
          'PatientID'=>$rpn_id,
          'PatientIDN'=>$iin,
          'PatientBirthDate'=>$birthDate,
          'FinanceSourceID'=>$fin_source,
          'VisitKindID'=>0,
          'TreatmentReasonID'=>$direction_reason,
          'Cost'=>0,
          'Count'=>1,
          'ServiceKind2'=>'0',
          'Diag_type'=>2,
          'LeasingID'=>'',
          'MKB10'=>$mkb10,
          'DoctorFirstName'=>'',
          'DoctorLastName'=>'',
          'DoctorMiddleName'=>'',
          'ServiceKind'=>0,
          'ServiceCDSKind'=>$ServiceCDSKind,
          'PaymentType'=>$paymentType,                   
          'Result'=>'Маммография не проведена',
          'Service'=>$service,
          'Place'=>'У',
          'Visit_type'=>'',
          'DateVerified'=>$DateVerified
        );
        $result_send_mh=$client->SetData(array(
          'sData'=>array(
              'Services'=>$Services
              
          ),
          'Token'=>$access_token
        ));
        $resultMis=$result_send_mh->return->ResultsMIS;
        $doctor_id=0;
        //echo $resultMis->Status;exit();
        if($resultMis->Status):
          if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            DB::table('pacient_app_info')->where('app_id',$id)->update(
            [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => 1,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
            ]);
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
            echo 'success';
          }
          else{
            DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => 1,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
            );
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
            echo 'success';
          }
        else:
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
          echo $resultMis->Info;
        endif;
        var_dump($value->id);
      }
      else{
        DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
      }     
    }
    return view('doctor/refrech');
  	return view('new_system_doctor/pdf_direct_lpu');
  }

	public function eps_connection_1(Request $request){
		$direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('date', 'LIKE', '2022-11-%')->where('id', '!=', 400061)
        ->where('info', 'Не добавлен')->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001', 'B06.516.005'])->whereNotNull('mkb10')->limit(1)->get();
      //var_dump(count($form_mkb10_eps));exit();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
          $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
          $mkb10_length = strlen($mkb10);
          if($iin and $mkb10 and $mkb10_length < 6 and $mkb10 != '.' and $mkb10 != '|'){
            $user = auth()->user();
            $getPatientData = AppData::getPatientDataEPS($iin,$rpn_token);  
            $patientData=json_decode($getPatientData);
            $rpn_id=$patientData->rpn_id??''; 
            $lastName=$patientData->lastName??''; 
            $firstName=$patientData->first_name??''; 
            $secondName=$patientData->surname??'';
            $sex=$patientData->sex??'1';
            $birthDate=$patientData->birthDate??'';
            $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
            $options = array(
                  'cache_wsdl' => 0,
                  'trace' => 1,
                  'stream_context' => stream_context_create(
                    array(
                    'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                      )
                    ))
                  );
            if($paymentType==3):
            $ServiceCDSKind=1800;
            elseif($paymentType==1):
            $ServiceCDSKind=1400;
            else:
            $ServiceCDSKind=1900;
            endif;
            $customer=400000000000006;
            $performer=400000000000006;
            if(!$pacient_app_info_exists){
              $id=rand(10,9000000);
              while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
                $id=rand(10,9000000);
              }
              $doctorPostId=0;
              $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
              $client = new \SoapClient($ftp_server,$options);
              $Services=array(
              'ID'=>$id,
              'Date'=>$executedServiceDate,
              'Customer'=>$customer,
              'Performer'=>$performer,
              'CustomerDepartament'=>0,
              'PerformerDepartament'=>0,
              'CustomerEmployee'=>$doctorPostId,
              'PerformerEmployee'=>0,
              'ServiceID'=>0,                       
              'PatientFirstName'=>$firstName,
              'PatientLastName'=>$lastName,
              'PatientMiddleName'=>$secondName,
              'PatientSexID'=>$sex,
              'PatientID'=>$rpn_id,
              'PatientIDN'=>$iin,
              'PatientBirthDate'=>$birthDate,
              'FinanceSourceID'=>$fin_source,
              'VisitKindID'=>0,
              'TreatmentReasonID'=>$direction_reason,
              'Cost'=>0,
              'Count'=>1,
              'ServiceKind2'=>'0',
              'Diag_type'=>2,
              'LeasingID'=>'',
              'MKB10'=>$mkb10,
              'DoctorFirstName'=>'',
              'DoctorLastName'=>'',
              'DoctorMiddleName'=>'',
              'ServiceKind'=>0,
              'ServiceCDSKind'=>$ServiceCDSKind,
              'PaymentType'=>$paymentType,                   
              'Result'=>'Маммография не проведена',
              'Service'=>$service,
              'Place'=>'У',
              'Visit_type'=>'',
              'DateVerified'=>$DateVerified
              );
              $result_send_mh=$client->SetData(
                array(
                'sData'=>array('Services'=>$Services),
                'Token'=>$access_token
                )
              );
      
              $resultMis=$result_send_mh->return->ResultsMIS;
              $doctor_id=0;
              if($resultMis->Status):
                if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
                  DB::table('pacient_app_info')->where('app_id',$id)->update(
                  [
                  'surname' => $lastName, 
                  'firstname' => $firstName,
                  'patronymic' => $secondName,
                  'birthday' => $birthDate,
                  'sex' =>$sex,
                  'iin' => $iin,
                  'address' => '',
                  'executedServiceDate' => $executedServiceDate,
                  'serviceKind2' => '0',
                  'direction_reason'=>$direction_reason,
                  'service' => $service,
                  'rpnid' => $rpn_id,
                  'serviceCost' => 0,
                  'serviceQuantity' => $serviceQuantity,
                  'mkb10' => $mkb10,
                  'paymentType' => $paymentType,
                  'result' => 'Маммография не проведена',
                  'status' => 'выполнено',
                  'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                  'info' => 'Добавлен',
                  'hospital_id'=>$user->hospital_id,
                  'resultMis'=>$resultMis->Info,
                  'result2'=>$resultMis->Info,
                  'doctor_id'=>$doctor_id,
                  'update_date'=>date('Y-m-d'),
                  'update_time'=>date('H:i:s'),
                  'auth_user'=>$user->id,
                  'form_mkb10_eps_id'=>$value->id
                  ]);
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
                else{
                  DB::table('pacient_app_info')->insert(
                  [
                    'surname' => $lastName, 
                    'firstname' => $firstName,
                    'patronymic' => $secondName,
                    'direction_reason'=>$direction_reason,
                    'birthday' => $birthDate,
                    'sex' =>$sex,
                    'iin' => $iin,
                    'address' => '',
                    'executedServiceDate' => $executedServiceDate,
                    'serviceKind2' => '0',
                    'service' => $service,
                    'rpnid' => $rpn_id,
                    'serviceCost' => 0,
                    'serviceQuantity' => $serviceQuantity,
                    'mkb10' => $mkb10,
                    'paymentType' => $paymentType,
                    'result' => 'Маммография не проведена',
                    'status' => 'выполнено',
                    'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                    'info' => 'Добавлен',
                    'app_id'=>$resultMis->ID,
                    'hospital_id'=>$user->hospital_id,
                    'resultMis'=>$resultMis->Info,
                    'result2'=>$resultMis->Info,
                    'doctor_id'=>$doctor_id,
                    'create_date'=>date('Y-m-d'),
                    'create_time'=>date('H:i:s'),
                    'auth_user'=>$user->id,
                    'form_mkb10_eps_id'=>$value->id
                  ]
                  );
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
              else:
                DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
                echo $resultMis->Info;
              endif;
              var_dump($value->id);
            }    
              
          }
          else{
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
          }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
	}
  public function eps_connection_2(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 394120)->where('id', '<', 397036)
        ->whereNull('info')->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->orderBy('id')->limit(1)->get();
      //var_dump(count($form_mkb10_eps));exit();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
              $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
              $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
              $direction_reason = 26;
            }
            else if($value->direction_reason == 'Подозрение на социально-значимое заболевание'){
              $direction_reason = 8;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
          else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
          $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
          $mkb10_length = strlen($mkb10);
          
          if($iin and $mkb10 and $mkb10_length < 6 and $mkb10 != '.' and $mkb10 != '|'){
            $user = auth()->user();
            $getPatientData = AppData::getPatientDataEPS($iin,$rpn_token);
            $patientData=json_decode($getPatientData);
            $rpn_id=$patientData->rpn_id??''; 
            $lastName=$patientData->lastName??''; 
            $firstName=$patientData->first_name??''; 
            $secondName=$patientData->surname??'';
            $sex=$patientData->sex??'1';
            $birthDate=$patientData->birthDate??'';
            $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
            $options = array(
                  'cache_wsdl' => 0,
                  'trace' => 1,
                  'stream_context' => stream_context_create(
                    array(
                    'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                      )
                    ))
                  );
            if($paymentType==3):
            $ServiceCDSKind=1800;
            elseif($paymentType==1):
            $ServiceCDSKind=1400;
            else:
            $ServiceCDSKind=1900;
            endif;
            $customer=400000000000006;
            $performer=400000000000006;
            if(!$pacient_app_info_exists){
              $id=rand(10,9000000);
              while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
                $id=rand(10,9000000);
              }
              $doctorPostId=0;
              $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
              $client = new \SoapClient($ftp_server,$options);
              $Services=array(
              'ID'=>$id,
              'Date'=>$executedServiceDate,
              'Customer'=>$customer,
              'Performer'=>$performer,
              'CustomerDepartament'=>0,
              'PerformerDepartament'=>0,
              'CustomerEmployee'=>$doctorPostId,
              'PerformerEmployee'=>0,
              'ServiceID'=>0,                       
              'PatientFirstName'=>$firstName,
              'PatientLastName'=>$lastName,
              'PatientMiddleName'=>$secondName,
              'PatientSexID'=>$sex,
              'PatientID'=>$rpn_id,
              'PatientIDN'=>$iin,
              'PatientBirthDate'=>$birthDate,
              'FinanceSourceID'=>$fin_source,
              'VisitKindID'=>0,
              'TreatmentReasonID'=>$direction_reason,
              'Cost'=>0,
              'Count'=>1,
              'ServiceKind2'=>'0',
              'Diag_type'=>2,
              'LeasingID'=>'',
              'MKB10'=>$mkb10,
              'DoctorFirstName'=>'',
              'DoctorLastName'=>'',
              'DoctorMiddleName'=>'',
              'ServiceKind'=>0,
              'ServiceCDSKind'=>$ServiceCDSKind,
              'PaymentType'=>$paymentType,                   
              'Result'=>'Маммография не проведена',
              'Service'=>$service,
              'Place'=>'У',
              'Visit_type'=>'',
              'DateVerified'=>$DateVerified
              );
              //var_dump($Services);exit();
              $result_send_mh=$client->SetData(
                array(
                'sData'=>array('Services'=>$Services),
                'Token'=>$access_token
                )
              );
      
              $resultMis=$result_send_mh->return->ResultsMIS;
              $doctor_id=0;
              if($resultMis->Status):
                if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
                  DB::table('pacient_app_info')->where('app_id',$id)->update(
                  [
                  'surname' => $lastName, 
                  'firstname' => $firstName,
                  'patronymic' => $secondName,
                  'birthday' => $birthDate,
                  'sex' =>$sex,
                  'iin' => $iin,
                  'address' => '',
                  'executedServiceDate' => $executedServiceDate,
                  'serviceKind2' => '0',
                  'direction_reason'=>$direction_reason,
                  'service' => $service,
                  'rpnid' => $rpn_id,
                  'serviceCost' => 0,
                  'serviceQuantity' => $serviceQuantity,
                  'mkb10' => $mkb10,
                  'paymentType' => $paymentType,
                  'result' => 'Маммография не проведена',
                  'status' => 'выполнено',
                  'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                  'info' => 'Добавлен',
                  'hospital_id'=>$user->hospital_id,
                  'resultMis'=>$resultMis->Info,
                  'result2'=>$resultMis->Info,
                  'doctor_id'=>$doctor_id,
                  'update_date'=>date('Y-m-d'),
                  'update_time'=>date('H:i:s'),
                  'auth_user'=>$user->id,
                  'form_mkb10_eps_id'=>$value->id
                  ]);
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
                else{
                  DB::table('pacient_app_info')->insert(
                  [
                    'surname' => $lastName, 
                    'firstname' => $firstName,
                    'patronymic' => $secondName,
                    'direction_reason'=>$direction_reason,
                    'birthday' => $birthDate,
                    'sex' =>$sex,
                    'iin' => $iin,
                    'address' => '',
                    'executedServiceDate' => $executedServiceDate,
                    'serviceKind2' => '0',
                    'service' => $service,
                    'rpnid' => $rpn_id,
                    'serviceCost' => 0,
                    'serviceQuantity' => $serviceQuantity,
                    'mkb10' => $mkb10,
                    'paymentType' => $paymentType,
                    'result' => 'Маммография не проведена',
                    'status' => 'выполнено',
                    'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                    'info' => 'Добавлен',
                    'app_id'=>$resultMis->ID,
                    'hospital_id'=>$user->hospital_id,
                    'resultMis'=>$resultMis->Info,
                    'result2'=>$resultMis->Info,
                    'doctor_id'=>$doctor_id,
                    'create_date'=>date('Y-m-d'),
                    'create_time'=>date('H:i:s'),
                    'auth_user'=>$user->id,
                    'form_mkb10_eps_id'=>$value->id
                  ]
                  );
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
              else:
                DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
                echo $resultMis->Info;
              endif;
              var_dump($value->id);
            }    
              
          }
          else{
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
          }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_3(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 397036)->where('id', '<', 399962)->whereNull('info')
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->orderBy('id')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $day = rand(1, 26);
        
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
          $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
          $mkb10_length = strlen($mkb10);
          if($iin and $mkb10 and $mkb10_length < 6 and $mkb10_length != 1 and $mkb10 != '|'){
            $user = auth()->user();
            $getPatientData = AppData::getPatientData($iin,$rpn_token);  
            $patientData=json_decode($getPatientData);
            $rpn_id=$patientData->rpn_id??''; 
            $lastName=$patientData->lastName??''; 
            $firstName=$patientData->first_name??''; 
            $secondName=$patientData->surname??'';
            $sex=$patientData->sex??'1';
            $birthDate=$patientData->birthDate??'';
            $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
            $options = array(
                  'cache_wsdl' => 0,
                  'trace' => 1,
                  'stream_context' => stream_context_create(
                    array(
                    'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                      )
                    ))
                  );
            if($paymentType==3):
            $ServiceCDSKind=1800;
            elseif($paymentType==1):
            $ServiceCDSKind=1400;
            else:
            $ServiceCDSKind=1900;
            endif;
            $customer=400000000000006;
            $performer=400000000000006;
            if(!$pacient_app_info_exists){
              $id=rand(10,9000000);
              while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              $id=rand(10,9000000);
              }
              $doctorPostId=0;
              $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
              $client = new \SoapClient($ftp_server,$options);
              $Services=array(
              'ID'=>$id,
              'Date'=>$executedServiceDate,
              'Customer'=>$customer,
              'Performer'=>$performer,
              'CustomerDepartament'=>0,
              'PerformerDepartament'=>0,
              'CustomerEmployee'=>$doctorPostId,
              'PerformerEmployee'=>0,
              'ServiceID'=>0,                       
              'PatientFirstName'=>$firstName,
              'PatientLastName'=>$lastName,
              'PatientMiddleName'=>$secondName,
              'PatientSexID'=>$sex,
              'PatientID'=>$rpn_id,
              'PatientIDN'=>$iin,
              'PatientBirthDate'=>$birthDate,
              'FinanceSourceID'=>$fin_source,
              'VisitKindID'=>0,
              'TreatmentReasonID'=>$direction_reason,
              'Cost'=>0,
              'Count'=>1,
              'ServiceKind2'=>'0',
              'Diag_type'=>2,
              'LeasingID'=>'',
              'MKB10'=>$mkb10,
              'DoctorFirstName'=>'',
              'DoctorLastName'=>'',
              'DoctorMiddleName'=>'',
              'ServiceKind'=>0,
              'ServiceCDSKind'=>$ServiceCDSKind,
              'PaymentType'=>$paymentType,                   
              'Result'=>'Маммография не проведена',
              'Service'=>$service,
              'Place'=>'У',
              'Visit_type'=>'',
              'DateVerified'=>$DateVerified
              );
              $result_send_mh=$client->SetData(
                array(
                  'sData'=>array('Services'=>$Services),
                  'Token'=>$access_token
                )
              );
      
              $resultMis=$result_send_mh->return->ResultsMIS;
              $doctor_id=0;
              if($resultMis->Status):
                if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
                  DB::table('pacient_app_info')->where('app_id',$id)->update(
                  [
                  'surname' => $lastName, 
                  'firstname' => $firstName,
                  'patronymic' => $secondName,
                  'birthday' => $birthDate,
                  'sex' =>$sex,
                  'iin' => $iin,
                  'address' => '',
                  'executedServiceDate' => $executedServiceDate,
                  'serviceKind2' => '0',
                  'direction_reason'=>$direction_reason,
                  'service' => $service,
                  'rpnid' => $rpn_id,
                  'serviceCost' => 0,
                  'serviceQuantity' => $serviceQuantity,
                  'mkb10' => $mkb10,
                  'paymentType' => $paymentType,
                  'result' => 'Маммография не проведена',
                  'status' => 'выполнено',
                  'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                  'info' => 'Добавлен',
                  'hospital_id'=>$user->hospital_id,
                  'resultMis'=>$resultMis->Info,
                  'result2'=>$resultMis->Info,
                  'doctor_id'=>$doctor_id,
                  'update_date'=>date('Y-m-d'),
                  'update_time'=>date('H:i:s'),
                  'auth_user'=>$user->id,
                  'form_mkb10_eps_id'=>$value->id
                  ]);
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
                else{
                  DB::table('pacient_app_info')->insert(
                  [
                    'surname' => $lastName, 
                    'firstname' => $firstName,
                    'patronymic' => $secondName,
                    'direction_reason'=>$direction_reason,
                    'birthday' => $birthDate,
                    'sex' =>$sex,
                    'iin' => $iin,
                    'address' => '',
                    'executedServiceDate' => $executedServiceDate,
                    'serviceKind2' => '0',
                    'service' => $service,
                    'rpnid' => $rpn_id,
                    'serviceCost' => 0,
                    'serviceQuantity' => $serviceQuantity,
                    'mkb10' => $mkb10,
                    'paymentType' => $paymentType,
                    'result' => 'Маммография не проведена',
                    'status' => 'выполнено',
                    'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                    'info' => 'Добавлен',
                    'app_id'=>$resultMis->ID,
                    'hospital_id'=>$user->hospital_id,
                    'resultMis'=>$resultMis->Info,
                    'result2'=>$resultMis->Info,
                    'doctor_id'=>$doctor_id,
                    'create_date'=>date('Y-m-d'),
                    'create_time'=>date('H:i:s'),
                    'auth_user'=>$user->id,
                    'form_mkb10_eps_id'=>$value->id
                  ]
                  );
                  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
                  echo 'success';
                }
              else:
                DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
                  'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
                echo $resultMis->Info;
              endif;
              var_dump($value->id);
            }    
              
          }
          else{
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
          }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_4(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 399962)->where('id', '<', 402901)->whereNull('info')
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->orderBy('id')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $day = rand(1, 26);
        
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $mkb10_length < 6 and $mkb10 != '.' and $mkb10 != '|'){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(
              array(
                'sData'=>array('Services'=>$Services),
                'Token'=>$access_token
              )
            );
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id,
              'form_mkb10_eps_id'=>$value->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id,
                'form_mkb10_eps_id'=>$value->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_5(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 402901)->where('id', '<', 405810)->whereNull('info')->whereNotNull('mkb10')
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->orderBy('id')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $day = rand(1, 26);
        
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $mkb10_length < 6 and $mkb10 != '.' and $mkb10 != '|'){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id,
              'form_mkb10_eps_id'=>$value->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id,
                'form_mkb10_eps_id'=>$value->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_6(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 376372)->where('id', '<=', 378154)
      ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNull('info')->whereNotNull('mkb10')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $day = rand(1, 12);
        
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 6 and $mkb10 != '.' and $mkb10 != '|'){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id,
              'form_mkb10_eps_id'=>$value->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id,
                'form_mkb10_eps_id'=>$value->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_7(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 378154)->where('id', '<=', 379953)
      ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNull('info')->whereNotNull('mkb10')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5 and $mkb10_length != 1){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_8(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 379953)->where('id', '<', 381745)
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->whereNull('info')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5 and $mkb10_length != 1){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_9(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 381745)->where('id', '<', 383547)
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->whereNull('info')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5 and $mkb10_length != 1){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_10(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>=', 383547)
        ->whereNotIn('code', ['B03.353.024', 'B06.129.006', 'B01.106.001'])->whereNotNull('mkb10')->whereNull('info')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d", strtotime($value->date));
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjY4ODcwMDY1LCJleHAiOjE2Njg5Mjc2NjUsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.UX29M-W3Gb6LsbfI8wgF6YHM2MzMQMPAq5uIQPqjL3VF2rPeu0G2uGOZZz1RrzcmYQatYK6LTt6YTrRTgHYQK2t9tNRIcZbIpZuCqpv3a2E69nOVu5iVg5r33FoGUkIw6T3cBCTUhZp_eOYIIHQpYf88C7LM0BPeyxaZ6ZZ_4Zn66cG3uasrFJYQ8-wTTyQfAPwo8CeGNYQ1BC4pwET_ACzGVxQkZmz51XAXQgYba9c9QTmG-MnRCciq6fU2vGqhCR2dq6GTDYdrpLg7R3fORJOF8U_-Ldoz7lliJzjXpwuZuSmru5q8s5gZJGjdm2yJ8tPEl9NGWRY_1v-EKt5KiQ";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjY4ODcwMDY2IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2ODg3MDA2NSwiZXhwIjoxNjY4OTI3NjY1LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.G6_kOcy-uIJmcJRS0iwGGFrHuLiH9BCR5ew5C_h0DXSb6cyg4tRYem7nZytOJIym5uAp6sc1MlNlI2AZW42JHPIsUKvCcsvPPNstJ84rWPAzsrZ0MMqUwt10JrB9p0nVkP7QHMHzrkUip6Cpil2QDnZdu8QmcB5EBGm3aU7d_OMDpkbVW5BN8DzIbkbqJyMcZLfWTiNQsmuCaN-W1LQq8uKqJKbWfewrzIPr3cA0mOgnoX5nnGnS6zznUwz0EJ4_zM5YS8EOSPzj1vKWw5AVFDIRf9wghxs9bppaJTMZ1bsRdGZrbl09e3suw8-22msMTB4EGAyzsyTrbMSxgp2Htw";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5 and $mkb10_length != 1){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_11(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 383547)->where('id', '<=', 385158)->whereNotNull('mkb10')->whereNull('info')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'form_mkb10_eps_id'=>$value->id
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_12(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 301628)->where('id', '<=', 304955)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_13(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 304955)->where('id', '<=', 308282)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10  and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_14(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 308282)->where('id', '<=', 311609)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_15(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 311609)->where('id', '<=', 314936)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_16(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 314936)->where('id', '<=', 318263)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_17(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 318263)->where('id', '<=', 321590)->where('info', 'Не добавлен')->whereNotNull('mkb10')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_18(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 321590)->where('id', '<=', 324917)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_19(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 324917)->where('id', '<=', 328244)->whereNotNull('mkb10')->where('info', 'Не добавлен')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  public function eps_connection_20(Request $request){
    $direction_reasons = [
      7, 8, 9, 10, 11,
      12, 13, 14, 15,
      16, 17, 18, 19,
      20, 21, 22, 23,
      24, 25, 26, 27,
      28, 29, 30, 31,
      32
      ];
      $serviceQuantity = 0;
      $form_mkb10_eps = DB::table('form_mkb10_eps')->where('id', '>', 328244)->whereNotNull('mkb10')->where('info', 'Не добавлен')->whereNotNull('mkb10')->limit(1)->get();
      $icd_type = 0;
      $direction_reason = 7;
      $sended_mo = 400000000000006;
      $sending_mo = 400000000000006;
      $paymentType = 2;
      $fin_source = 73;
      // $access_token = AppIntegrateMis::get_token();
      // var_dump($access_token);
      // $rpn_token = AppData::get_token();
      // var_dump($rpn_token);exit();
      
      foreach ($form_mkb10_eps as $key => $value) {
        var_dump($value->id);
        $mkb10 = $value->mkb10;
        $iin = $value->pacient_iin;
        $service = $value->code;
        $executedServiceDate = date("Y-m-d");
    
        $pacient_app_info_exists = DB::table('pacient_app_info')->where(
          [
            'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
            'service' => $service
          ])->exists();
        if(!$pacient_app_info_exists){
          $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjYxMjU2NjQzLCJleHAiOjE2NjEzMTQyNDMsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.I9zSMbjwTQ7l3_fvNWzcj9U0Atm3GoFbVO_LL-O3KiZflXUCEW7QyaxxSyXoO2YV2_rk2LPWgJZob7mPgZ-Br2iraIY0Tv1IYbADyP_Bm71iBGcDYJvpi1B7IjkO_VcU8GGG8OL-g2p1ixm2OnpT2CocIIkXGaUJwVBlmiY2eOu8kylZjopCESKJHmTrJVSh0UeugUZ0bVEx8TphFJ-FYmToU6wExq1wFrN-IyXVvDn9JxTOyBrH-cgYK7-wzG2Hbs51ZA7aeibbuOVThVk_8KE-453AzT4lM_LOP-lsDdECCsQtHsoK42NwbVQwnKynGDk1s5giKsNP_mmIGJ76Bg";
          $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjYxMjU2NjQ1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY2MTI1NjY0NCwiZXhwIjoxNjYxMzE0MjQ0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.j8HIBrY-C_2FKIolGbULUmhJallkk8WGMZdbiY4dQE3ziLTnYnIoxYBEfCv5-pyKK_ZKSvEPqtNGBROsPqBjUi3TusN4PB5XC76hb9sBRnNS9nJoFjpOHc2_Yv_2F-jAtnwmBrz5SSl8BKkK5-nBabegMKUp-iPSaFWN-wPYeBuchF8Zdsj0X73Avo6p8EfWXNLSfuibPfFoSbU6QT9JyUJJ7eHub8qCxHyhKAEFpwapWnn0k-YtGCjxQ9Wh_-iVtBoAguGWP2Mu0WOYVWGLXNXI2bGiROhc2MZlG3zjCQwESh-OEQoxrDfu_wT8uOMTyJaJz-7Y2nHfcdj8CzF-oA";
          if($value->direction_reason){
            if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
            $direction_reason = 7;
            }
            else if($value->direction_reason == 'Скрининг'){
            $direction_reason = 17;
            }
            else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
            $direction_reason = 26;
            }
          }
    
          if($value->number_services):
            $serviceQuantity = $value->number_services;
           else:
            $serviceQuantity = 1;
          endif;
        
        
        // if(substr($value->code, 0, 1) == 'B'){
        //   $icd_type = 50;
        // }
        // elseif(substr($value->code, 0, 1) == 'A'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'D'){
        //   $icd_type = 73;
        // }
        // elseif(substr($value->code, 0, 1) == 'C'){
        //   $icd_type = 71;
        // }
        $mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
        $mkb10_length = strlen($mkb10);
        if($iin and $mkb10 and $service and $mkb10_length < 5){
          $user = auth()->user();
          $getPatientData = AppData::getPatientData($iin,$rpn_token);  
          $patientData=json_decode($getPatientData);
          $rpn_id=$patientData->rpn_id??''; 
          $lastName=$patientData->lastName??''; 
          $firstName=$patientData->first_name??''; 
          $secondName=$patientData->surname??'';
          $sex=$patientData->sex??'1';
          $birthDate=$patientData->birthDate??'';
          $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
          $options = array(
                'cache_wsdl' => 0,
                'trace' => 1,
                'stream_context' => stream_context_create(
                  array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                  ))
                );
          if($paymentType==3):
          $ServiceCDSKind=1800;
          elseif($paymentType==1):
          $ServiceCDSKind=1400;
          else:
          $ServiceCDSKind=1900;
          endif;
          $customer=400000000000006;
          $performer=400000000000006;
          if(!$pacient_app_info_exists){
            $id=rand(10,9000000);
            while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
            $id=rand(10,9000000);
            }
            $doctorPostId=0;
            $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
            $client = new \SoapClient($ftp_server,$options);
            $Services=array(
            'ID'=>$id,
            'Date'=>$executedServiceDate,
            'Customer'=>$customer,
            'Performer'=>$performer,
            'CustomerDepartament'=>0,
            'PerformerDepartament'=>0,
            'CustomerEmployee'=>$doctorPostId,
            'PerformerEmployee'=>0,
            'ServiceID'=>0,                       
            'PatientFirstName'=>$firstName,
            'PatientLastName'=>$lastName,
            'PatientMiddleName'=>$secondName,
            'PatientSexID'=>$sex,
            'PatientID'=>$rpn_id,
            'PatientIDN'=>$iin,
            'PatientBirthDate'=>$birthDate,
            'FinanceSourceID'=>$fin_source,
            'VisitKindID'=>0,
            'TreatmentReasonID'=>$direction_reason,
            'Cost'=>0,
            'Count'=>1,
            'ServiceKind2'=>'0',
            'Diag_type'=>2,
            'LeasingID'=>'',
            'MKB10'=>$mkb10,
            'DoctorFirstName'=>'',
            'DoctorLastName'=>'',
            'DoctorMiddleName'=>'',
            'ServiceKind'=>0,
            'ServiceCDSKind'=>$ServiceCDSKind,
            'PaymentType'=>$paymentType,                   
            'Result'=>'Маммография не проведена',
            'Service'=>$service,
            'Place'=>'У',
            'Visit_type'=>'',
            'DateVerified'=>$DateVerified
            );
            $result_send_mh=$client->SetData(array(
            'sData'=>array(
              'Services'=>$Services
              
            ),
            'Token'=>$access_token
            ));
    
            $resultMis=$result_send_mh->return->ResultsMIS;
            $doctor_id=0;
            if($resultMis->Status):
            if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
              DB::table('pacient_app_info')->where('app_id',$id)->update(
              [
              'surname' => $lastName, 
              'firstname' => $firstName,
              'patronymic' => $secondName,
              'birthday' => $birthDate,
              'sex' =>$sex,
              'iin' => $iin,
              'address' => '',
              'executedServiceDate' => $executedServiceDate,
              'serviceKind2' => '0',
              'direction_reason'=>$direction_reason,
              'service' => $service,
              'rpnid' => $rpn_id,
              'serviceCost' => 0,
              'serviceQuantity' => $serviceQuantity,
              'mkb10' => $mkb10,
              'paymentType' => $paymentType,
              'result' => 'Маммография не проведена',
              'status' => 'выполнено',
              'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
              'info' => 'Добавлен',
              'hospital_id'=>$user->hospital_id,
              'resultMis'=>$resultMis->Info,
              'result2'=>$resultMis->Info,
              'doctor_id'=>$doctor_id,
              'update_date'=>date('Y-m-d'),
              'update_time'=>date('H:i:s'),
              'auth_user'=>$user->id
              ]);
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else{
              DB::table('pacient_app_info')->insert(
              [
                'surname' => $lastName, 
                'firstname' => $firstName,
                'patronymic' => $secondName,
                'direction_reason'=>$direction_reason,
                'birthday' => $birthDate,
                'sex' =>$sex,
                'iin' => $iin,
                'address' => '',
                'executedServiceDate' => $executedServiceDate,
                'serviceKind2' => '0',
                'service' => $service,
                'rpnid' => $rpn_id,
                'serviceCost' => 0,
                'serviceQuantity' => $serviceQuantity,
                'mkb10' => $mkb10,
                'paymentType' => $paymentType,
                'result' => 'Маммография не проведена',
                'status' => 'выполнено',
                'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
                'info' => 'Добавлен',
                'app_id'=>$resultMis->ID,
                'hospital_id'=>$user->hospital_id,
                'resultMis'=>$resultMis->Info,
                'result2'=>$resultMis->Info,
                'doctor_id'=>$doctor_id,
                'create_date'=>date('Y-m-d'),
                'create_time'=>date('H:i:s'),
                'auth_user'=>$user->id
              ]
              );
              DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
              echo 'success';
            }
            else:
            DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
              'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
            echo $resultMis->Info;
            endif;
            var_dump($value->id);
          }    
            
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
        }
    
        }
        else{
          DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
            'info'=>'Дублировка']);
        }           
      }
      return view('doctor/refrech');
  }
  
	public function eps_connection_errors(Request $request){
		$direction_reasons = [
			7, 8, 9, 10, 11,
			12, 13, 14, 15,
			16, 17, 18, 19,
			20, 21, 22, 23,
			24, 25, 26, 27,
			28, 29, 30, 31,
			32
		  ];
		  $serviceQuantity = 0;
		  $form_mkb10_eps = DB::table('form_mkb10_eps')->where('date', 'LIKE', '%.06.2022')->where('code', 'LIKE', 'C03%')->where('info', 'Не добавлен')->get();
		  //$form_mkb10_eps =  DB::table('form_mkb10_eps')->whereNotNull('mkb10')->where('form_id', 78)->whereNull('info')->limit(1)->get();
		  $icd_type = 0;
		  $direction_reason = 7;
		  $sended_mo = 400000000000006;
		  $sending_mo = 400000000000006;
		  $paymentType = 2;
		  $fin_source = 73;
		  // $access_token = AppIntegrateMis::get_token();
		  // var_dump($access_token);
		  // $rpn_token = AppData::get_token();
		  // var_dump($rpn_token);exit();
		  
		  foreach ($form_mkb10_eps as $key => $value) {
			  var_dump($value->id);
			  $mkb10 = $value->mkb10;
			  $iin = $value->pacient_iin;
			  $service = $value->code;
			  $executedServiceDate = date("Y-m-d", strtotime($value->date));
	  
			  $pacient_app_info_exists = DB::table('pacient_app_info')->where(
				  [
					  'iin'=>$iin, 'executedServiceDate' => $executedServiceDate,
					  'service' => $service
				  ])->exists();
			  if(!$pacient_app_info_exists){
				  $access_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiIxNGVjMjg5MGI4NDg0MDYzYWNkNTQ4MTgyYWIwZmNmZCIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjU2NjUzODA0IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOiJFeGNoYW5nZUFpc0Z1bGwiLCJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwicHJlZmVycmVkX3VzZXJuYW1lIjoiNTkwMzAyMzAyMzQ2IiwiZmlyc3RfbmFtZSI6ItCR0JDQl9CQ0KDQkdCV0JoiLCJsYXN0X25hbWUiOiLQo9CQ0KLQkNCZIiwibWlkZGxlX25hbWUiOiLQo9CQ0KLQkNCZ0KPQm9CrIiwib2hjX2lkIjoiNDU1MDAwMDAwMDAwMDEwMDQiLCJvaGNfbmFtZSI6ItCi0J7QniBcIkluQ3liZXJTZXJ2aWNlXCIiLCJvaGNfY29kZSI6IlpIMjEiLCJvaGNfcmVnaW9uX2lkIjoiMTQiLCJvaGNfc3RhdGVfaWQiOiIxNCIsIm9oY19zdGF0ZV9rYXRvIjoiNjMwMDAwMDAwIiwib2hjX2ZzX2lkIjoiNDU1MDAwMDAwMDAwMjQ3NDciLCJvaGNfZnNfbmFtZSI6ItCe0YLQtNC10LtfMSIsInBlcnNvbl9pZCI6Mzk0OTgyMzYxLCJnZW5kZXIiOiJNIiwiYmlydGhkYXRlIjoiMDIuMDMuMTk1OSIsInBlcnNvbl9paW4iOiI1OTAzMDIzMDIzNDYiLCJwb3N0X2lkIjoiNDU1MDAwMDAwMDE1NjI4NTEiLCJwb3N0X2Z1bmNfaWQiOiIxMDAwMDAwMDAwMDAwMDEiLCJwb3N0X25hbWUiOiLQlNC40YDQtdC60YLQvtGAIiwibmJmIjoxNjU2NjUzODA0LCJleHAiOjE2NTY3MTE0MDQsImlzcyI6Imh0dHBzOi8vd3d3LmVpc3oua3oiLCJhdWQiOiJodHRwczovL3d3dy5laXN6Lmt6L3Jlc291cmNlcyJ9.r0Vx7HPQjfqvUGwArb_7jMhFHlY210H7Q_JYXGrSVchbZ57G7EjPJ33AiCKmBAqF3RCdLReQ80BHp6LH4FIAMiE9UnOY0fdwDgbjn5OE_1-e8bivCW_2gvwIFbD_THLFsubkJtjXVXtsihgpLcvUmOV6l5IsSyg0V3OJYghrPGHnAbY6roUdjTCzJAEl4hb1Zke1PLNJQBji1rXVCFtF3HVPQ3g5hMiuFILOUP0TBvTVpUcDWeGjuoEa63XY5-9qWeFQqOsqmsgnqqw4PI6munqI_SxoJJNWlvZdllyDFxEMcY3zOFsylmY3D-x0RaIZsIM9CyrU-UbrFG87Lyq42g";
				  $rpn_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFGMkIzQTYyOTE5MTYxNDBEMTEyQ0U2OTZCMjk4MEUxMTU2RDBFODYiLCJ4NXQiOiJIeXM2WXBHUllVRFJFczVwYXltQTRSVnREb1kiLCJ0eXAiOiJKV1QifQ.eyJjbGllbnRfaWQiOiI2MjMwZmU2MzhhOGY0NGM3OTA2NjkzNDA0MzVkOTg0MSIsImNsaWVudF90eXBlIjoiaW50Iiwic3ViIjoiZThhNGVjN2YtMGZjMC1lOTExLWFiNWYtMDA1MDU2ODEwMWUxIiwiYW1yIjoicGFzc3dvcmQiLCJhdXRoX3RpbWUiOiIxNjU2NjUzODA1IiwiaWRwIjoiYXV0aHNydiIsInJvbGUiOlsiRXh0ZXJuYWxTZWFyY2hQYXRpZW50cyIsIlZpZXdQZXJzb24iXSwibmFtZSI6IjU5MDMwMjMwMjM0NiIsInByZWZlcnJlZF91c2VybmFtZSI6IjU5MDMwMjMwMjM0NiIsImZpcnN0X25hbWUiOiLQkdCQ0JfQkNCg0JHQldCaIiwibGFzdF9uYW1lIjoi0KPQkNCi0JDQmSIsIm1pZGRsZV9uYW1lIjoi0KPQkNCi0JDQmdCj0JvQqyIsIm9oY19pZCI6IjQ1NTAwMDAwMDAwMDAxMDA0Iiwib2hjX25hbWUiOiLQotCe0J4gXCJJbkN5YmVyU2VydmljZVwiIiwib2hjX2NvZGUiOiJaSDIxIiwib2hjX3JlZ2lvbl9pZCI6IjE0Iiwib2hjX3N0YXRlX2lkIjoiMTQiLCJvaGNfc3RhdGVfa2F0byI6IjYzMDAwMDAwMCIsIm9oY19mc19pZCI6IjQ1NTAwMDAwMDAwMDI0NzQ3Iiwib2hjX2ZzX25hbWUiOiLQntGC0LTQtdC7XzEiLCJwZXJzb25faWQiOjM5NDk4MjM2MSwiZ2VuZGVyIjoiTSIsImJpcnRoZGF0ZSI6IjAyLjAzLjE5NTkiLCJwZXJzb25faWluIjoiNTkwMzAyMzAyMzQ2IiwicG9zdF9pZCI6IjQ1NTAwMDAwMDAxNTYyODUxIiwicG9zdF9mdW5jX2lkIjoiMTAwMDAwMDAwMDAwMDAxIiwicG9zdF9uYW1lIjoi0JTQuNGA0LXQutGC0L7RgCIsIm5iZiI6MTY1NjY1MzgwNCwiZXhwIjoxNjU2NzExNDA0LCJpc3MiOiJodHRwczovL3d3dy5laXN6Lmt6IiwiYXVkIjoiaHR0cHM6Ly93d3cuZWlzei5rei9yZXNvdXJjZXMifQ.sBBtrSu39JeaNu6lXB06BYEoIsaPB9DYSRnLKXTgEk-GUtbmRz_goVHwiicT3ERczfOcusZ7x8cxQ-Xp0jrYUyRYSLm4qG934Kj-SOlSCsBZk8IZMUV8wz2Ji_LCkeGqFq_nIDXn-3ckfsHrmKHQRJ_4gKah_MH7RGvANbxAlYaMvIS6laD7hdbQBjQZjtc45wYVFVAOWuU_EUM2ASZp8MGsBYE84mYe0hwiv4rYc636peMmiqqmWOfY_MmUgNBx0srdL5fW66Cg9PG-jtgpaXGUl3cIl1FwyRFaeMm0kCY9ZFJJSuzA0a_RNDR6PMJd7Y1k4WfWzt2AG3flovnCGw";
				  if($value->direction_reason){
					  if($value->direction_reason == 'Острое заболевание/Обострение хронического заболевания'){
						$direction_reason = 7;
					  }
					  else if($value->direction_reason == 'Скрининг'){
						$direction_reason = 17;
					  }
					  else if($value->direction_reason == 'Динамическое наблюдение с хроническими заболеваниями'){
						$direction_reason = 26;
					  }
				  }
	  
					if($value->number_services):
					  $serviceQuantity = $value->number_services;
				   else:
					  $serviceQuantity = 1;
					endif;
				
				
				// if(substr($value->code, 0, 1) == 'B'){
				//   $icd_type = 50;
				// }
				// elseif(substr($value->code, 0, 1) == 'A'){
				//   $icd_type = 73;
				// }
				// elseif(substr($value->code, 0, 1) == 'D'){
				//   $icd_type = 73;
				// }
				// elseif(substr($value->code, 0, 1) == 'C'){
				//   $icd_type = 71;
				// }
				$mkb10 = trim(str_replace('.','',explode('|',$mkb10)[0]));
				$mkb10_length = strlen($mkb10);
				if($iin and $mkb10 and $service and $mkb10_length < 5){
				  $user = auth()->user();
				  $getPatientData = AppData::getPatientData($iin,$rpn_token);  
				  $patientData=json_decode($getPatientData);
				  $rpn_id=$patientData->rpn_id??''; 
				  $lastName=$patientData->lastName??''; 
				  $firstName=$patientData->first_name??''; 
				  $secondName=$patientData->surname??'';
				  $sex=$patientData->sex??'1';
				  $birthDate=$patientData->birthDate??'';
				  $ftp_server = "https://appmis.eisz.kz/app/ws/ws1.1cws?wsdl";
				  $options = array(
							  'cache_wsdl' => 0,
							  'trace' => 1,
							  'stream_context' => stream_context_create(
									array(
									'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
									  )
								  ))
							  );
				  if($paymentType==3):
					$ServiceCDSKind=1800;
				  elseif($paymentType==1):
					$ServiceCDSKind=1400;
				  else:
					$ServiceCDSKind=1900;
				  endif;
				  $customer=400000000000006;
				  $performer=400000000000006;
				  if(!$pacient_app_info_exists){
					  $id=rand(10,9000000);
					  while(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
						$id=rand(10,9000000);
					  }
					  $doctorPostId=0;
					  $DateVerified=$paymentType!=3 ? null : date('Y-m-d');
					  $client = new \SoapClient($ftp_server,$options);
					  $Services=array(
						'ID'=>$id,
						'Date'=>$executedServiceDate,
						'Customer'=>$customer,
						'Performer'=>$performer,
						'CustomerDepartament'=>0,
						'PerformerDepartament'=>0,
						'CustomerEmployee'=>$doctorPostId,
						'PerformerEmployee'=>0,
						'ServiceID'=>0,                       
						'PatientFirstName'=>$firstName,
						'PatientLastName'=>$lastName,
						'PatientMiddleName'=>$secondName,
						'PatientSexID'=>$sex,
						'PatientID'=>$rpn_id,
						'PatientIDN'=>$iin,
						'PatientBirthDate'=>$birthDate,
						'FinanceSourceID'=>$fin_source,
						'VisitKindID'=>0,
						'TreatmentReasonID'=>$direction_reason,
						'Cost'=>0,
						'Count'=>1,
						'ServiceKind2'=>'0',
						'Diag_type'=>2,
						'LeasingID'=>'',
						'MKB10'=>$mkb10,
						'DoctorFirstName'=>'',
						'DoctorLastName'=>'',
						'DoctorMiddleName'=>'',
						'ServiceKind'=>0,
						'ServiceCDSKind'=>$ServiceCDSKind,
						'PaymentType'=>$paymentType,                   
						'Result'=>'Маммография не проведена',
						'Service'=>$service,
						'Place'=>'У',
						'Visit_type'=>'',
						'DateVerified'=>$DateVerified
					  );
					  $result_send_mh=$client->SetData(array(
						'sData'=>array(
							'Services'=>$Services
							
						),
						'Token'=>$access_token
					  ));
					  var_dump($result_send_mh);
	  
					  $resultMis=$result_send_mh->return->ResultsMIS;
					  $doctor_id=0;
					  if($resultMis->Status):
						if(DB::table('pacient_app_info')->where('app_id', $id)->exists()){
						  DB::table('pacient_app_info')->where('app_id',$id)->update(
						  [
							'surname' => $lastName, 
							'firstname' => $firstName,
							'patronymic' => $secondName,
							'birthday' => $birthDate,
							'sex' =>$sex,
							'iin' => $iin,
							'address' => '',
							'executedServiceDate' => $executedServiceDate,
							'serviceKind2' => '0',
							'direction_reason'=>$direction_reason,
							'service' => $service,
							'rpnid' => $rpn_id,
							'serviceCost' => 0,
							'serviceQuantity' => $serviceQuantity,
							'mkb10' => $mkb10,
							'paymentType' => $paymentType,
							'result' => 'Маммография не проведена',
							'status' => 'выполнено',
							'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
							'info' => 'Добавлен',
							'hospital_id'=>$user->hospital_id,
							'resultMis'=>$resultMis->Info,
							'result2'=>$resultMis->Info,
							'doctor_id'=>$doctor_id,
							'update_date'=>date('Y-m-d'),
							'update_time'=>date('H:i:s'),
							'auth_user'=>$user->id
						  ]);
						  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
							'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
						  echo 'success';
						}
						else{
						  DB::table('pacient_app_info')->insert(
							[
							  'surname' => $lastName, 
							  'firstname' => $firstName,
							  'patronymic' => $secondName,
							  'direction_reason'=>$direction_reason,
							  'birthday' => $birthDate,
							  'sex' =>$sex,
							  'iin' => $iin,
							  'address' => '',
							  'executedServiceDate' => $executedServiceDate,
							  'serviceKind2' => '0',
							  'service' => $service,
							  'rpnid' => $rpn_id,
							  'serviceCost' => 0,
							  'serviceQuantity' => $serviceQuantity,
							  'mkb10' => $mkb10,
							  'paymentType' => $paymentType,
							  'result' => 'Маммография не проведена',
							  'status' => 'выполнено',
							  'orgName' => 'ГКП на ПХВ "Многопрофильный медицинский центр" акимата города Нур-Султан',
							  'info' => 'Добавлен',
							  'app_id'=>$resultMis->ID,
							  'hospital_id'=>$user->hospital_id,
							  'resultMis'=>$resultMis->Info,
							  'result2'=>$resultMis->Info,
							  'doctor_id'=>$doctor_id,
							  'create_date'=>date('Y-m-d'),
							  'create_time'=>date('H:i:s'),
							  'auth_user'=>$user->id
							]
						  );
						  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
							'info'=>'Добавлен', 'app_id'=>$resultMis->ID, 'result'=>$resultMis->Info]);
						  echo 'success';
						}
					  else:
						DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
							'info'=>'Не добавлен', 'result'=>$resultMis->Info]);
						echo $resultMis->Info;
					  endif;
					  var_dump($value->id);
				  }    
					  
				}
				else{
				  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
						'info'=>'Не добавлен', 'result'=>'Не найден ИИН']);
				}
	  
			  }
			  else{
				  DB::table('form_mkb10_eps')->where('id',  $value->id)->update([
						'info'=>'Дублировка']);
			  }	          
		  }         
	}
}

?>