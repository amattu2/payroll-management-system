<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class LeaveApproved extends Notification
{
  use Queueable;

  private Leave $leave;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Leave $leave)
  {
    $this->leave = $leave;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
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
      ->subject("Leave Request Approved")
      ->replyTo(Auth()->user()->email)
      ->greeting("Hello!")
      ->line(new HtmlString(__("messages.leave.status", [
        "status" => "approved",
        "start" => $this->leave->start_date->format('m/d/Y'),
        "end" => $this->leave->end_date->format('m/d/Y'),
        "when" => $this->leave->approved_at,
        "name" => Auth()->user()->name
      ])));
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
