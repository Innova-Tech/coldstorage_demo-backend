<?php


namespace App\Repositories\Interfaces;


interface ReportRepositoryInterface
{
    public function fetchAllSalaries($month);
    public function getDeposits($month);
    public function getBanks();
    public function fetchReceiveReceiptInfo($receivegroup_id);
    public function fetchDeliveryReceiptInfo($deliverygroup_id);
    public function fetchBookingReceiptInfo($id);
    public function fetchLoanDisbursementInfo($id);
    public function fetchLoanCollectionInfo($id);
    public function fetchGatepass($delivey_id);
    public function fetchAccountingInformation($start_date, $end_date): array;
    public function downloadStorePotatoReceipt($client_id,$date);

}
