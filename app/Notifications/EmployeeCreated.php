<?php
/*
 * Produced: Mon Jul 04 2022
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

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeCreated extends Notification
{
  use Queueable;

  public Employee $employee;

  /**
   * Create a new notification instance.
   *
   * @param Employee $employee
   * @return void
   */
  public function __construct(Employee $employee)
  {
    $this->employee = $employee;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail', WebhookChannel::class];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject("Employee Created")
      ->replyTo(Auth()->user()->email)
      ->greeting("Hello!")
      ->line(__("messages.employee.created", [
        "name" => $this->employee->firstname ." ". $this->employee->lastname,
      ]))
      ->action('View', route('employees.employee', $this->employee->id));
  }

  /**
   * Get the webhook representation of the notification.
   *
   * @param mixed $notifiable
   * @return WebhookMessage
   */
  public function toWebhook($notifiable)
  {
    return WebhookMessage::create()->data([
      "event" => "employee.created",
      "data" => $this->employee->toArray(),
    ]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [];
  }
}
