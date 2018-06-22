<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TicketRepository;
use App\Models\Traits\TicketTrait;
use Carbon\Carbon;

class TicketController extends Controller
{
    use TicketTrait;

    protected $ticketRepo;

    public function __construct(TicketRepository $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = $this->ticketRepo->list(1);

        $data  = compact('tickets');

        return view('ticket', $data);
    }

    public function createTickets()
    {
        $count = 990;
        $nos   = $this->generate($count);

        $datas = [];
        foreach ($nos as $no) {
            array_push($datas, [
                'user_id' => null,
                'no' => $no,
                'status' => 0,
                'created_at' => Carbon::now('Asia/Taipei'),
                'updated_at' => Carbon::now('Asia/Taipei'),
            ]);
        }
        $this->ticketRepo->createTickets($datas);
    }

    public function bindUser()
    {
        $userId = 1;

        $response = $this->ticketRepo->bindUserToTicket($userId);

        dd($response);
    }
}
