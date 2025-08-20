<?php

namespace Calendar\View\Helper\Cell\Render;

use Booking\Service\BookingStatusService;
use Zend\View\Helper\AbstractHelper;

class OccupiedForPrivileged extends AbstractHelper
{

    protected $bookingStatusService;

    public function __construct(BookingStatusService $bookingStatusService)
    {
        $this->bookingStatusService = $bookingStatusService;
    }

    public function __invoke(array $reservations, array $cellLinkParams)
    {
        $view = $this->getView();

        $reservationsCount = count($reservations);

        if ($reservationsCount > 1) {
            return $view->calendarCellLink($this->view->t('Occupied'), $view->url('backend/booking/edit', [], $cellLinkParams), 'cc-single');
        } else {
            $reservation = current($reservations);
            $booking = $reservation->needExtra('booking');
            $bookingStatusColor = $this->bookingStatusService->getStatusColor($booking->getBillingStatus());

            if (strstr($booking->getMeta('notes', ''),'VM') !== false) {
                $cellVM = ' cc-vm';
            } else {
                $cellVM = '';
            }

            if ($bookingStatusColor) {
                $cellStyle = 'outline: solid 3px ' . $bookingStatusColor;
            } else {
                $cellStyle = null;
            }

            $cellLabel = $booking->needExtra('user')->need('alias');
            if ($cellVM !== '') {
                $cellLabel .= ' (VM)';
            }

            $cellGroup = ' cc-group-' . $booking->need('bid');
            $cellGroup .= $cellVM;

            switch ($booking->need('status')) {
                case 'single':
                    return $view->calendarCellLink($view->escapeHtml($cellLabel), $view->url('backend/booking/edit', [], $cellLinkParams), 'cc-single' . $cellGroup, null, $cellStyle);
                case 'subscription':
                    return $view->calendarCellLink($cellLabel, $view->url('backend/booking/edit', [], $cellLinkParams), 'cc-multiple' . $cellGroup, null, $cellStyle);
            }
        }
    }

}
