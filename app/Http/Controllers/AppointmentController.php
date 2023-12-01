<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request): Application|View|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->has('start') && $request->has('end')) {
            $start = $request->get('start', '');
            $end = $request->get('end', '');
            $appointments = Appointment::query()
                ->whereBetween('appointment_date', [$start, $end])
                ->join('users', 'users.id', '=', 'appointments.user_id')
                ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
                ->select('appointments.*', 'users.full_name', 'treatments.treatment_name')
                ->get();
        } else {
            $appointments = Appointment::query()
                ->join('users', 'users.id', '=', 'appointments.user_id')
                ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
                ->select('appointments.*', 'users.full_name', 'treatments.treatment_name')
                ->get();
        }

        if ($request->wantsJson()) {
            return response()->json(['appointments' => $appointments]);
        }
        return view('pages.appointment-management', ['appointments' => $appointments]);

    }

    public function calendarEvents(Request $request)
    {
        switch ($request->type) {
            case 'create':
                $event = Appointment::create([
                    'user_id' => $request->user_id,
                    'treatment_id' => $request->treatment_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'is_consultation' => $request->is_consultation,
                    'is_all_day' => $request->is_all_day,
                    'note' => $request->note,
                    'status' => $request->status,
                ]);

                return response()->json($event);

            case 'edit':
                $event = Appointment::find($request->id)->update([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);

            case 'delete':
                $event = Appointment::find($request->id)->delete();

                return response()->json($event);

            default:
                # ...
                break;
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required',
            'treatment_id' => 'required',
            'appointment_date' => 'required',
            'note' => 'nullable',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json([
            'message' => 'Đặt lịch thành công',
            'appointment' => $appointment
        ]);
    }

    public function show($id): JsonResponse
    {
        $appointment = Appointment::query()
            ->where('appointments.id', $id)
            ->join('users', 'users.id', '=', 'appointments.user_id')
            ->join('treatments', 'treatments.id', '=', 'appointments.treatment_id')
            ->select('appointments.*', 'users.full_name', 'users.phone_number', 'treatments.treatment_name', 'treatments.price')
            ->first();
        return response()->json([
            'appointment' => $appointment,
        ]);
    }
}
