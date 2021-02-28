<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-sm-8 offset-sm-2">
                            <h3 class="font-12"><b>Edit a job Details</b></h3>
                            <div>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div><br />
                                @endif
                                <form method="post" action="/jobs/{{$job->id}}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-group">

                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" name="name" value={{ $job->name }} />
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="text" class="form-control" name="email" value={{ $job->email }}>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input type="text" class="form-control" name="phone" value={{ $job->phone }}>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" name="address" value={{ $job->address }} required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Gender</label>
                                        <input type=radio name="gender" value="male" {{ $job->gender == 'male' ? 'checked' : ''}}> Male</option>
                                        <input type=radio name="gender" value="female" {{ $job->gender == 'female' ? 'checked' : ''}}> Female</option>

                                    </div>

                                    <hr>
                                    <h4 class="mb-4 mt-4"><strong>Education</strong></h4>
                                    @foreach($job->educations as $index => $edu)
                                    <div class="row form-group">
                                        <div class="col-2 form-group ">
                                            <label class="mt-8">{{$edu->type}}</label>
                                            <input type="hidden" class="form-control" name="education[{{$index}}][type]" value="{{$edu->type}}">
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="board">Board</label>
                                                <input type="text" class="form-control" name="education[{{$index}}][board]" value="{{$edu->board}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="year">Year</label>
                                                <input type="text" class="form-control" name="education[{{$index}}][year]" value="{{$edu->year}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="percentage">Percentage</label>
                                                <input type="text" class="form-control" name="education[{{$index}}][percentage]" value="{{$edu->percentage}}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <hr>
                                    <h4 class="mb-4 mt-4"><strong>Work Expreience</strong></h4>
                                    @foreach($job->workExperience as $index => $work)
                                    <div class="row form-group">
                                        <div class="col-3 form-group ">
                                            <label>Comapny</label>
                                            <input type="text" class="form-control" name="experience[{{$index}}][company]" value="{{$work->company}}">
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                <input type="text" class="form-control" name="experience[{{$index}}][designation]" value="{{$work->designation}}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="start_date">Start date</label>
                                                <input type="date" class="form-control" name="experience[{{$index}}][start_date]" value="{{$work->start_date}}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="end_date">End date</label>
                                                <input type="date" class="form-control" name="experience[{{$index}}][end_date]" value="{{$work->end_date}}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <hr>
                                    <h4 class="mb-4 mt-4"><strong>Known Languages</strong></h4>
                                    @foreach($job->language as $index => $lang)
                                    <div class="row form-group">
                                        <div class="col-2 form-group ">
                                            <label>{{ucFirst($lang->language)}}</label>
                                            <input type="hidden" class="form-control" name="languages[{{$index}}][language]" value="{{$lang->language}}">
                                        </div>
                                        <div class="col-2 form-group ">
                                            <input type="checkbox" class="form-control" name="languages[{{$index}}][read]" {{ $lang->read ? 'checked' : ''}} value="1">
                                            <label>Read</label>
                                        </div>
                                        <div class="col-2 form-group ">
                                            <input type="checkbox" class="form-control" name="languages[{{$index}}][write]" {{ $lang->write ? 'checked' : ''}} value="1">
                                            <label>Write</label>
                                        </div>
                                        <div class="col-2 form-group ">
                                            <input type="checkbox" class="form-control" name="languages[{{$index}}][speak]" {{ $lang->speak ? 'checked' : ''}} value="1">
                                            <label>Speak</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <hr>
                                    <h4 class="mb-4 mt-4"><strong>Technical Experience</strong></h4>
                                    @foreach($job->technicalExperiences as $index => $tech)
                                    <div class="row form-group">
                                        <div class="col-2 form-group ">
                                            <label>{{ucFirst($tech->technology)}}</label>
                                            <input type="hidden" class="form-control" name="techExperience[{{$index}}][technology]" value="{{$tech->technology}}">
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type=radio name="techExperience[{{$index}}][type]" value="beginner" {{ $tech->type == 'beginner' ? 'checked' : ''}}> Beginner</option>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type=radio name="techExperience[{{$index}}][type]" value="mediator" {{ $tech->type == 'mediator' ? 'checked' : ''}}> Mediator</option>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type=radio name="techExperience[{{$index}}][type]" value="expert" {{ $tech->type == 'expert' ? 'checked' : ''}}> Expert</option>
                                        </div>
                                    </div>
                                    @endforeach
                                    <hr>
                                    <h4 class="mb-4 mt-4"><strong>Preference</strong></h4>
                                    <div class="row">
                                        <div class="col-6">
                                            <select name="location_id" class="form-control">
                                                @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ $job->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="expected_ctc">Expected ctc:</label>
                                            <input type="text" class="form-control" name="expected_ctc" value={{ $job->expected_ctc }}>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="current_ctc">Current ctc:</label>
                                            <input type="text" class="form-control" name="current_ctc" value={{ $job->current_ctc }}>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="notice_period">Notice period:</label>
                                            <input type="text" class="form-control" name="notice_period" value={{ $job->notice_period }}>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-4">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

</x-app-layout>
