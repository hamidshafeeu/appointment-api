<?php

namespace App\Http\Controllers;

use App\Helpers\Dhifaau;
use Illuminate\Http\Request;

class StaticResourcesController extends Controller
{
    public function atolls(Dhifaau $dhifaau)
    {
        return $dhifaau->atolls();
    }
    
    public function atoll_islands($id, Dhifaau $dhifaau)
    {
        return $dhifaau->islands_per_atoll($id);
    }
    
    public function island_centers($id, Dhifaau $dhifaau)
    {
        return $dhifaau->centers_per_island($id);
    }
    
    public function center_dates($id, Dhifaau $dhifaau)
    {
        return $dhifaau->getOpenDates();
    }
    
    public function center_date_slots($id, $date, Dhifaau $dhifaau)
    {
        return $dhifaau->getSlots();
    }
}
