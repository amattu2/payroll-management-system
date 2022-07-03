<?php

namespace App\Notifications;

use App\Models\Timesheet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TimesheetFinalized extends Notification
{
  use Queueable;

  private Timesheet $timesheet;

  /**
   * Create a new notification instance.
   *
   * @param Timesheet $timesheet
   * @return void
   */
  public function __construct(Timesheet $timesheet)
  {
    $this->timesheet = $timesheet;
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
      ->subject($this->timesheet->period->format('F, Y') . " Timesheet Finalized")
      ->replyTo(Auth()->user()->email)
      ->error()
      ->greeting("Hello!")
      ->line(__("messages.timesheet.finalized", [
        "period" => $this->timesheet->period->format('F, Y'),
        "when" => $this->timesheet->updated_at,
      ]))
      ->attachData($this->timesheet->toPDF()->output("S"), "timesheet.pdf");
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
