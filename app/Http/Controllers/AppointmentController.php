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
                ->whereDate('start_date', '>=', $start)
                ->whereDate('end_date', '<=', $end)
                ->join('users', 'users.id', '=', 'appointments.user_id')
                ->leftJoin('treatments', 'treatments.id', '=', 'appointments.treatment_id')
                ->select('appointments.*', 'users.full_name', 'treatments.treatment_name')
                ->get();
        } else {
            $appointments = Appointment::query()
                ->join('users', 'users.id', '=', 'appointments.user_id')
                ->leftJoin('treatments', 'treatments.id', '=', 'appointments.treatment_id')
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
                if ($event) {
                    return response()->json([
                        'success' => 'Thêm lịch thành công',
                    ]);
                } else {
                    return response()->json(['error' => 'Có lỗi trong quá trình tạo.']);
                }

            case 'edit':
                $event = Appointment::find($request->id)->update([
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);

                if ($event) {
                    return response()->json([
                        'success' => 'Cập nhật lịch thành công',
                    ]);
                } else {
                    return response()->json(['error' => 'Có lỗi trong quá trình cập nhật.']);
                }

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
            'start_date' => 'required',
            'end_date' => 'required',
            'is_consultation' => 'nullable',
            'is_all_day' => 'nullable',
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
            ->leftJoin('treatments', 'treatments.id', '=', 'appointments.treatment_id')
            ->select('appointments.*', 'users.full_name', 'users.phone_number', 'treatments.treatment_name', 'treatments.price')
            ->first();

        return response()->json([
            'appointment' => $appointment,
        ]);
    }
}
