<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Ticket;

class TicketRepository
{
	protected $ticket;

	public function __construct(Ticket $ticket)
	{
		$this->ticket = $ticket;
	}

	// ticket list
	public function list($status = 0)
	{
		return $this->ticket->where('status', $status)->orderBy('id','desc')->get();
	}

	// mutiple create tickets
	public function createTickets($datas = [])
	{
		DB::table('ticket')->insert($datas);
	}

	// update ticket status
	public function updateTicketStatus($ticketId, $status = -1)
	{
		return $this->ticket->where('id', $ticketId)->update([
								'status' => $status
							]);
	}

	//validate user have ticket
	public function canTakeTicket($userId = null)
	{	
		if ($userId === null) {
			return false;
		}

		return $this->ticket->where('user_id',$userId)->count() == 0 ? true : false;
	}

	// bind user to ticket
	public function bindUserToTicket($userId = null)
	{
		if (!$this->canTakeTicket($userId)) {
			return false;
		}

		$ticket = $this->ticket
					->where('status', 0)
					->where('user_id',null)
					->get()
					->shuffle()
					->first();

		$ticket->user_id = $userId;
		$ticket->status  = 1;
		$ticket->save();

		return true;
	}
}

