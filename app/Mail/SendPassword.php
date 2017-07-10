<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPassword extends Mailable
{
  use Queueable, SerializesModels;


  /**
   * @var
   */
  private $pass;
  /**
   * @var
   */
  private $address;

  public function __construct($address, $pass)
  {
    $this->to($address);
    $this->pass = $pass;
    $this->address = $address;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $this->subject('金生金后台账户');

    return $this->view('mail.pass')->with([
      'pass'  => $this->pass,
      'email' => $this->address
    ]);
  }
}
