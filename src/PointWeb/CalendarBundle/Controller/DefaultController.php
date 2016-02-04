<?php

namespace PointWeb\CalendarBundle\Controller;

use PointWeb\CalendarBundle\Entity\CalendarEvent;
use PointWeb\CalendarBundle\Entity\CalendarEventRepository;
use PointWeb\CalendarBundle\Form\CalendarEventSearchType;
use PointWeb\UserBundle\Entity\User;
use PointWeb\UserBundle\Entity\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request, $year, $month)
    {
        $em = $this->getDoctrine()->getManager();
        if ($year < 1970) {
            $year = date('Y');
        }
        if ($month < 1) {
            $month = date('m');
        }

        if ($request->getMethod() == 'POST') {
            $request->getSession()->set('filterCalendar', $request->get('id_user'));
        }
        if ($request->getSession()->get('filterCalendar')) {
            $selected_user = $request->getSession()->get('filterCalendar');
        } else {
            $selected_user = 0;
        }
        $weekStart = new \DateTime($year . '-' . $month . '-01');
        $weekStart = $weekStart->format('W');
        $calendar = $this->drawWeekCalendar($weekStart, $year, $selected_user);
        for ($i = $weekStart + 1; $i <= $weekStart + 6; $i++) {
            $calendar .= $this->drawWeekCalendar($i, $year, $selected_user);
        }
        $users = $em->getRepository('PointWebUserBundle:User')->findBy(array('enabled' => 1));
        return $this->render('PointWebCalendarBundle:Default:index.html.twig', array(
            'calendar' => $calendar,
            'year' => $year,
            'nextYear' => ($month == 12 ? $year + 1 : $year),
            'lastYear' => ($month == 1 ? $year - 1 : $year),
            'month' => $month,
            'nextMonth' => ($month == 12 ? 1 : $month + 1),
            'lastMonth' => ($month == 1 ? 12 : $month - 1),
            'users' => $users,
            'selected_user' => $selected_user
        ));
    }

    public function drawWeekCalendar($week, $year, $user_selected = 0)
    {
        $first_day_of_week = $this->getFirstDay($year, $week);
        $calendar = '<div class="col-lg-12 week week' . $week . '"><table cellpadding="0" cellspacing="0" class="calendar">';
        $calendar .= '<thead>';
        $calendar .= '<tr class="calendar-row">';
        $calendar .= '<td class="calendar-day-head"></td>';
        $calendar .= '<td class="calendar-day-head" colspan="11">Lundi ' . $first_day_of_week->format("d-m-Y") . '</td>';
        $second_day_of_week = $first_day_of_week;
        $calendar .= '<td class="calendar-day-head" colspan="11">Mardi ' . $second_day_of_week->add(new \DateInterval('P1D'))->format("d-m-Y") . '</td>';
        $third_day_of_week = $second_day_of_week;
        $calendar .= '<td class="calendar-day-head" colspan="11">Mercredi ' . $third_day_of_week->add(new \DateInterval('P1D'))->format("d-m-Y") . '</td>';
        $fourth_day_of_week = $third_day_of_week;
        $calendar .= '<td class="calendar-day-head" colspan="11">Jeudi ' . $fourth_day_of_week->add(new \DateInterval('P1D'))->format("d-m-Y") . '</td>';
        $fifth_day_of_week = $fourth_day_of_week;
        $calendar .= '<td class="calendar-day-head" colspan="11">Vendredi ' . $fifth_day_of_week->add(new \DateInterval('P1D'))->format("d-m-Y") . '</td>';
        $calendar .= '</tr>';
        $calendar .= '<tr class="calendar-row">';
        $calendar .= '<td class="calendar-hours-head"></td>';

        for ($j = 0; $j < 5; $j++) {
            for ($i = 8; $i < 19; $i++) {
                $calendar .= '<td class="calendar-hours-head">' . $i . '-' . ($i + 1) . '</td>';
            }
        }
        $calendar .= '</tr>';
        $calendar .= '<thead><tbody>';
        $em = $this->getDoctrine()->getManager();
        /** @var UserRepository $repo */
        $repo = $em->getRepository('PointWebUserBundle:User');
        /** @var CalendarEventRepository $repoCal */
        $repoCal = $em->getRepository('PointWebCalendarBundle:CalendarEvent');
        if ($user_selected != 0) {
            $users = $repo->findBy(array('enabled' => 1, 'id' => $user_selected));
        } else {
            $users = $repo->findBy(array('enabled' => 1));
        }
        /** @var User $user */
        foreach ($users as $user) {
            $formated_date = $user->getCreateDate()->format('dmy');
            $hex = bin2hex($user->getFirstName() . $formated_date . $user->getLastName() . $user->getId() . $formated_date);
            $hex1 = substr($hex, 0, 3);
            $hex2 = substr($hex, 1, 3);
            $hex3 = substr($hex, 2, 3);
            $color = 'rgb(255,255,255)';
            switch ($user->getColor()) {
                case 'red':
                    $color = 'rgb(255,171,171)';
                    break;
                case 'orange':
                    $color = 'rgb(255,208,133)';
                    break;
                case 'green':
                    $color = 'rgb(151,255,133)';
                    break;
                case 'grey':
                    $color = 'rgb(209,209,209)';
                    break;
                case 'blue':
                    $color = 'rgb(148,219,255)';
                    break;
                case 'yellow':
                    $color = 'rgb(255,253,148)';
                    break;
            }
            $calendar .= '<tr class="calendar-row" style="background-color: ' . $color . '">';
            $calendar .= '<td class="calendar-day">' . $user->getFullname() . '</td>';
            $events = $repoCal->getEventsWeek($user, $this->getFirstDay($year, $week), $fifth_day_of_week);
            for ($j = 0; $j < 5; $j++) {
                for ($i = 8; $i < 19; $i++) {
                    if ($events) {
                        $tab[$i] = array();
                        /** @var CalendarEvent $event */
                        foreach ($events as $event) {
                            $day_tmp = $this->getFirstDay($year, $week);
                            switch ($j) {
                                case '1':
                                    $day_tmp = $this->getFirstDay($year, $week)->add(new \DateInterval('P1D'));
                                    break;
                                case '2':
                                    $day_tmp = $this->getFirstDay($year, $week)->add(new \DateInterval('P2D'));
                                    break;
                                case '3':
                                    $day_tmp = $this->getFirstDay($year, $week)->add(new \DateInterval('P3D'));
                                    break;
                                case '4':
                                    $day_tmp = $this->getFirstDay($year, $week)->add(new \DateInterval('P4D'));
                                    break;
                            }
                            $date_tmp = mktime($i, 0, 0, $day_tmp->format('m'), $day_tmp->format('d'), $day_tmp->format('Y'));
                            $day_to_compare = new \DateTime();
                            $day_to_compare->setTimestamp($date_tmp);
                            if ($event->getStartDate()->getTimestamp() <= $date_tmp && $event->getEndDate()->getTimestamp() > $date_tmp) {

                                if ($event->getEndDate()->getTimestamp() > $day_to_compare->setTime(19, 0, 0)->getTimestamp() && ($event->getStartDate()->getTimestamp() < $day_to_compare->setTime(19, 0, 0)->getTimestamp() && $event->getStartDate()->getTimestamp() > $day_to_compare->setTime(8, 0, 0)->getTimestamp())) {
                                    if ((int)$event->getStartDate()->format('H') < 8) {
                                        $hours = 8 - (int)$event->getStartDate()->format('H');
                                    } else {
                                        $hours = (int)$event->getStartDate()->format('H');
                                    }
                                    $hours = 19 - $hours;
                                    if ($hours < 0) {
                                        $hours = 0;
                                    }
                                    $tab[$i]['inc'] = $hours;
                                } elseif ($event->getStartDate()->getTimestamp() < $day_to_compare->setTime(8, 0, 0)->getTimestamp() && ($event->getEndDate()->getTimestamp() < $day_to_compare->setTime(19, 0, 0)->getTimestamp() && $event->getEndDate()->getTimestamp() > $day_to_compare->setTime(8, 0, 0)->getTimestamp())) {
                                    if ((int)$event->getEndDate()->format('H') > 19) {
                                        $hours = 19 - (int)$event->getEndDate()->format('H');
                                    } else {
                                        $hours = (int)$event->getEndDate()->format('H');
                                    }
                                    $hours = $hours - 8;
                                    if ($hours < 0) {
                                        $hours = 0;
                                    }
                                    $tab[$i]['inc'] = ($hours - 1);
                                } elseif ($event->getStartDate()->getTimestamp() < $day_to_compare->setTime(8, 0, 0)->getTimestamp() && $event->getEndDate()->getTimestamp() > $day_to_compare->setTime(19, 0, 0)->getTimestamp()) {
                                    $hours = 11;
                                    $tab[$i]['inc'] = $hours;
                                } else {
                                    if ((int)$event->getStartDate()->format('H') < 8) {
                                        $hours = 8;
                                    } else {
                                        $hours = (int)$event->getStartDate()->format('H');
                                    }
                                    if ((int)$event->getEndDate()->format('H') > 19) {
                                        $hours2 = 19;
                                    } else {
                                        $hours2 = (int)$event->getEndDate()->format('H');
                                    }
                                    $hours = 19 - $hours;
                                    $hours2 = $hours2 - 8;
                                    $hours = $hours2 - $hours;
                                    if ($hours < 0) {
                                        $hours = 0;
                                    }
                                    $tab[$i]['inc'] = $hours;
                                }
                                $tab[$i]['html'] = '<td class="calendar-day" colspan="' . $hours . '" style="background-color: ' . $color . '">' . $event->getDescription() . '</td>';

                            } else {
                                if (!isset($tab[$i]['html'])) {
                                    $tab[$i]['html'] = '<td class="calendar-day" style="background-color: rgb(255,255,255)"></td>';
                                }
                                if (!isset($tab[$i]['inc'])) {
                                    $tab[$i]['inc'] = 0;
                                }
                            }
                        }
                        $calendar .= $tab[$i]['html'];
                        $i += $tab[$i]['inc'];
                    } else {
                        $calendar .= '<td class="calendar-day" style="background-color: rgb(255,255,255)"></td>';
                    }
                }
            }
        }
        $calendar .= '</tbody>';
        $calendar .= '</table></div>';
        return $calendar;
    }

    public function getFirstDay($year, $week)
    {
        $timestamp = mktime(0, 0, 0, 1, 1, $year) + (($week - 1) * 7 * 24 * 60 * 60);
        $timestamp_for_monday = $timestamp - 86400 * (date('N', $timestamp) - 1);
        $date_for_monday = new \DateTime();
        $date_for_monday->setTimestamp($timestamp_for_monday);
        return $date_for_monday;
    }
}
