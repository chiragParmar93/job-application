<?php

namespace App\Http\Controllers;

use App\Http\Requests\Job\JobRequest;
use App\Models\Job;
use DataTables;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return view('jobs');
    }

    public function initData()
    {
        $data = [];
        $data['locations'] = \App\Models\Location::all();
        $data['experiences'] = \App\Models\Experience::all();
        $data['languages'] = \App\Models\Language::all();

        return response()->json([
            "status" => 200,
            "success" => true,
            "data" => $data,
        ]);
    }

    /**
     * Get Job listing data using Ajax
     *
     */
    public function getjobs(Request $request)
    {
        if ($request->ajax()) {
            $data = Job::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="jobs/' . $data->id . '/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="remove" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Create Applicaion form
     *
     */
    public function store(JobRequest $request)
    {
        $data = $request->all();

        $job = Job::create($data);

        if ($job) {
            if (!empty($data['experience'])) {
                $exprienseData = [];
                foreach ($data['experience'] as $element) {
                    $element['start_date'] = date('Y-m-d', strtotime($element['start_date']));
                    $element['end_date'] = date('Y-m-d', strtotime($element['end_date']));
                    $exprienseData[] = $element;
                }
                $job->workExperience()->createMany($exprienseData);
            }

            if (!empty($data['languages'])) {
                $job->language()->createMany($data['languages']);
            }

            if (!empty($data['techExperience'])) {
                $job->technicalExperiences()->createMany($data['techExperience']);
            }

            if (!empty($data['education'])) {
                $job->educations()->createMany($data['education']);
            }

            return response()->json([
                "status" => 200,
                "success" => true,
                "message" => "Job successfully saved.",
            ]);
        }
    }

    /**
     * Edit specified job.
     *
     */
    public function edit($id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->load(['educations', 'language', 'technicalExperiences', 'workExperience']);
            $locations = \App\Models\Location::all();
            return view('job-edit', compact('job', 'locations'));
        }
    }

    /**
     * Update job data.
     *
     */
    public function update(JobRequest $request, $id)
    {
        $data = $request->all();
        $job = Job::find($id);
        $job->name = $request->get('name');
        $job->email = $request->get('email');
        $job->phone = $request->get('phone');
        $job->gender = $request->get('gender');
        $job->address = $request->get('address');
        $job->location_id = $request->get('location_id');
        $job->expected_ctc = $request->get('expected_ctc');
        $job->current_ctc = $request->get('current_ctc');
        $job->notice_period = $request->get('notice_period');
        $job->save();
        if ($job) {
            if (!empty($request->get('education'))) {
                $job->educations()->delete();
                $job->educations()->createMany($request->get('education'));
            }

            if (!empty($data['experience'])) {
                $exprienseData = [];
                foreach ($data['experience'] as $element) {
                    $element['start_date'] = date('Y-m-d', strtotime($element['start_date']));
                    $element['end_date'] = date('Y-m-d', strtotime($element['end_date']));
                    $exprienseData[] = $element;
                }
                $job->workExperience()->delete();
                $job->workExperience()->createMany($exprienseData);
            }
            if (!empty($data['techExperience'])) {
                $job->technicalExperiences()->delete();
                $job->technicalExperiences()->createMany($data['techExperience']);
            }

            if (!empty($data['languages'])) {
                $job->language()->delete();
                $job->language()->createMany($data['languages']);
            }
        }

        return redirect('/jobs')->with('success', 'Job updated!');
    }

    /**
     * Remove the specified job from storage.
     *
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        if ($job) {
            $job->workExperience()->delete();
            $job->language()->delete();
            $job->technicalExperiences()->delete();
            $job->educations()->delete();
            $job->delete();
        }
    }
}
