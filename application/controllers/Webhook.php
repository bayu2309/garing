<?php defined('BASEPATH') OR exit('No direct script access allowed');



// SDK for create bot

use \LINE\LINEBot;

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;



// SDK for build message

use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

use \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;



// SDK for build button and template action

use \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;

use \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;



class Webhook extends CI_Controller {


	private $events;

	private $signature;


	private $bot;

	private $user;


	function __construct()

	{

		parent::__construct();
		// create bot object
		$httpClient = new CurlHTTPClient($_ENV['MTn2latTZ4NmBnuah67007iRDPdliDVKkpxR1yb5IGpzTARdjzAqSnLmhkvew0EqfNs3wDSQuTc8j/DUfKCoPFpV3ECtur1KUxyiRd1jZjeS9JA7yJXlkuK6l6/WkCJEKDybBDiRMdFbYxtFlRYOmQdB04t89/1O/w1cDnyilFU=']);
		$this->bot  = new LINEBot($httpClient, ['channelSecret' => $_ENV['adbb3952c8bc75b90664aa5ededbbbec']]);
		$this->load->model('tebakangaring_m');

	}


	public function index()

	{

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

			echo "Mau ngapain sih?";

			header('HTTP/1.1 400 Only POST method allowed');

			exit;

		}


        // get request

		$body = file_get_contents('php://input');

		$this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE'])

		? $_SERVER['HTTP_X_LINE_SIGNATURE']

		: "-";

		$this->events = json_decode($body, true);


		$this->tebakangaring_m->log_events($this->signature, $body);

		foreach ($this->events['events'] as $event)

		{

   // skip group and room event

			if(! isset($event['source']['userId'])) continue;



   // get user data from database

			$this->user = $this->tebakangaring_m->getUser($event['source']['userId']);

   // respond event

			if($event['type'] == 'message'){

				if(method_exists($this, $event['message']['type'].'Message')){

					$this->{$event['message']['type'].'Message'}($event);

				}

			}

			else {

				if(method_exists($this, $event['type'].'Callback')){

					$this->{$event['type'].'Callback'}($event);
				}

			}
		}

	}

	private function followCallback($event)
	{

		$res = $this->bot->getProfile($event['source']['userId']);

		if ($res->isSucceeded())

		{

			$profile = $res->getJSONDecodedBody();



        // save user data

			$this->tebakangaring_m->saveUser($profile);
			// send welcome message
			$message = "Halo, " . $profile['displayName'] . "!\n";
			$message .= "Seberapa garingkah Anda?\n\nYuk mari kita tes dengan menjawab beberapa pertanyaan-pertanyaan garing!\n\n";
			$message .= "Kirim pesan \"START\" untuk memulai.";
			$textMessageBuilder = new TextMessageBuilder($message);
			$this->bot->pushMessage($event['source']['userId'], $textMessageBuilder);
			$stickerMessageBuilder = new StickerMessageBuilder(3, 180);
			$this->bot->pushMessage($event['source']['userId'], $stickerMessageBuilder);

		}

	}

	private function textMessage($event)

	{

		$userMsg = $event['message']['text'];
		$userMessage = strtolower($userMsg);


		if($this->user['number'] == 0)

		{

			if($userMessage == 'start')

			{
				$getnum = $this->tebakangaring_m->countQuestions();
				$message = "Silakan pilih nomor kuis yang Anda inginkan\n(ketik nomor kuis, antara 1 sampai ".$getnum.")";
				$textMessageBuilder = new TextMessageBuilder($message);
				$this->bot->pushMessage($event['source']['userId'], $textMessageBuilder);

				//$getnum = $this->tebakangaring_m->countQuestions();
				//$gettest = $this->db->get('questions')->row_array();
				//$count = count($gettest);
				//$num = rand(1,16);


            // update number progress

				//$this->tebakangaring_m->setUserProgress($this->user['user_id'], $num);


            // send question

				//$this->sendQuestion($this->user['user_id'], $num);


			} else {

				$message = 'Silakan kirim pesan "START" untuk memulai kuis.';

				$textMessageBuilder = new TextMessageBuilder($message);

				$this->bot->pushMessage($event['source']['userId'], $textMessageBuilder);

			}


        // if user already begin test

		}
		elseif ($this->user['number'] > 0) {
			$this->checkAnswer($userMessage);

	}

	private function pilihKuis($message){
					$pilihMsg = $event['message']['text'];
					$getnum = $this->tebakangaring_m->countQuestions();
					if($pilihMsg > 0 || $pilihMsg < $getnum+1){
						$this->sendQuestion($this->user['user_id'], $pilihMsg);
					}else{
						
					}
				}

	public function sendQuestion($user_id, $questionNum)

	{

    // get question from database

		$question = $this->tebakangaring_m->getQuestion($questionNum);


    // prepare answer options

		/*for($ans = "1"; $ans <= "3"; $opsi++) {

			if(!empty($question['ans'.$opsi]))

				$options[] = new MessageTemplateActionBuilder($question['option_'.$opsi], $question['option_'.$opsi]);

			}*/


    // prepare button template

			//$buttonTemplate = new ButtonTemplateBuilder("Kegaringan Nomor ".$question['number'], $question['text']);
			$tempe = "Kegaringan Nomor : " . $question['number'] . "\n\n";
			$tempe .= "Pertanyaan : " . $question['text'];
			$textMessageBuilder = new TextMessageBuilder($tempe);

    // build message

			//$messageBuilder = new TemplateMessageBuilder("Gunakan mobile app untuk melihat soal", $buttonTemplate);


    // send message

			$response = $this->bot->pushMessage($user_id, $textMessageBuilder);

		}

		private function checkAnswer($message)

		{

    // if answer is true, increment score

			if($this->tebakangaring_m->isAnswerEqual($this->user['number'], $message)){

				//$this->user['score']++;
				//$this->tebakangaring_m->setScore($this->user['user_id'], $this->user['score']);
				//$msg = 'Skormu '. $this->user['score'] ."\n" . 'ketik "START" untuk bermain lagi.';
				$msg = "duh ketebak! harus lebih garing lagi nih pertanyaannya...";
				$textMessageBuilder = new TextMessageBuilder($msg);
				$this->bot->pushMessage($this->user['user_id'], $textMessageBuilder);
				$stickerMessageBuilder = new StickerMessageBuilder(3, 190);
				$this->bot->pushMessage($this->user['user_id'], $stickerMessageBuilder);

				$this->sendPenjelasan($this->user['user_id'],$this->user['number']);
				$this->tebakangaring_m->setTry($this->user['user_id'], 0);
				$this->tebakangaring_m->setUserProgress($this->user['user_id'], 0);
				$next = "ketik \"START\" untuk bermain lagi.";
				$txtMsg = new TextMessageBuilder($next);
				$this->bot->pushMessage($this->user['user_id'],$txtMsg);

			}

		else {

        // show salah
			$coba = $this->user['try'];
			if($coba<3){

				$coba++;

				$message = 'Tet-Not! Salah! Coba lagi! ('.$coba.')';//' Percobaan ke-'.$coba;

				$textMessageBuilder = new TextMessageBuilder($message);

				$this->bot->pushMessage($this->user['user_id'], $textMessageBuilder);

				$this->tebakangaring_m->setTry($this->user['user_id'], $coba);
			}
			else{

				$message = 'Ah payah! Masa pertanyaan gini doang gabisa jawab sih!? Jawabannya adalah : ';

				$textMessageBuilder = new TextMessageBuilder($message);

				$this->bot->pushMessage($this->user['user_id'], $textMessageBuilder);

				$this->sendPenjelasan($this->user['user_id'],$this->user['number']);
				$this->tebakangaring_m->setTry($this->user['user_id'], 0);
				$this->tebakangaring_m->setUserProgress($this->user['user_id'], 0);
			}
		}

	}

	private function sendPenjelasan($user_id, $questionNum){
		$question = $this->tebakangaring_m->getQuestion($questionNum);

    // prepare button template

		//$buttonTemplate = new ButtonTemplateBuilder("[Penjelasan] Kegaringan Nomor ".$question['number'], $question['text'], $question['penjelasan']);
		$tempe = "[Penjelasan]\nKegaringan Nomor : " . $question['number'] . "\n\n";
		$tempe .= "Pertanyaan : " . $question['text'] . "\n\n";
		$tempe .= "Jawaban : " .$question['answer1'] ."\n\n";
		$tempe .= "Jawaban alternatif : " .$question['answer2'] ."\n\n";
		$tempe .= "Jawaban alternatif : " .$question['answer3'] ."\n\n";
		$tempe .= "Penjelasan : " . $question['penjelasan'];
		$textMessageBuilder = new TextMessageBuilder($tempe);


    // build message

		//$messageBuilder = new TemplateMessageBuilder("Gunakan mobile app untuk melihat soal", $buttonTemplate);


    // send message

		$response = $this->bot->pushMessage($user_id, $textMessageBuilder);

	}

}
