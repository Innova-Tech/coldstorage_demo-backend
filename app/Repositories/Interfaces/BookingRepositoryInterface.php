<?php


namespace App\Repositories\Interfaces;


interface BookingRepositoryInterface
{
    public function getBookingListBySearchedQuery($query);
    public function getBookingDetail($booking_no);
    public function getPaginatedRecentBookings();
    public function getBookingListByClient($client_id);
    public function saveBooking(array $request);
}
