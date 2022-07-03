<?php
/*
 * Produced: Thu Jun 30 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Email Subject
   *
   * @var string
   */
  public string $emailSubject;

  /**
   * Raw Email Body
   *
   * @var string
   */
  public string $emailBody;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(string $subject, string $body)
  {
    $this->emailSubject = $subject;
    $this->emailBody = $body;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject($this->emailSubject)
      ->replyTo(Auth()->user()->email)
      ->view("emails.custom");
  }
}
