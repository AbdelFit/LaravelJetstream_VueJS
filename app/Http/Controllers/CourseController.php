<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('user')
                    ->withCount('episodes')
                    ->latest()
                    ->get();

        foreach($courses as $course)
        {
            $course->participants = DB::table('completions')
                                    ->where('user_id', '<>', auth()->id())
                                    ->join('episodes', 'episodes.id', '=', 'completions.episode_id')
                                    ->where('episodes.course_id', $course->id)
                                    ->distinct('user_id')
                                    ->count('user_id');
        }

        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Courses/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required', 'array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required'
        ]);

        $course = Course::create($request->all());

        foreach($request->input('episodes') as $episode) 
        {
            $episode['course_id'] = $course->id;
            Episode::create($episode);
        }
        
        return Redirect::route('userCourses')->with('success', 'Formation mise en ligne !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Courses/Show', [
            'course' => Course::where('id', $id)->with('episodes')->first(),
            'watched' => auth()->user()->episodes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Courses/Edit', [
            'course' => Course::where('id', $id)->with('episodes')->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required', 'array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required'
        ]);

        $course = Course::where('id', $id)->first();
        $course->update($request->all());
        $course->episodes()->delete();

        foreach($request->episodes as $episode) 
        {
            unset($episode['id'], $episode['created_at'], $episode['updated_at']);
            $episode['course_id'] = $course->id;
            Episode::create($episode);
        }
        
        return Redirect::route('userCourses')->with('success', 'Formation mise à jour !');

        /*return Inertia::render('Courses/Edit', [
            'course' => Course::where('id', $id)->with('episodes')->first()
        ])->with('success', 'Formation mise à jour !');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episodes = Episode::where('course_id', $id)->get();
        foreach($episodes as $episode) {
            $completions = DB::table('completions')->where('episode_id', $episode->id)->delete();
        }
        Episode::where('course_id', $id)->delete();
        Course::where('id', $id)->delete();
        
        return Redirect::route('userCourses')->with('success', 'Formation supprimée !');
    }

    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');
        $user = auth()->user();

        $user->episodes()->toggle($id);

        return $user->episodes;
    }

    public function userCourses()
    {
        $courses = Course::where('user_id', auth()->id())
                    ->withCount('episodes')
                    ->latest()
                    ->get();

        foreach($courses as $course)
        {
            $course->participants = DB::table('completions')
                                    ->where('user_id', '<>', auth()->id())
                                    ->join('episodes', 'episodes.id', '=', 'completions.episode_id')
                                    ->where('episodes.course_id', $course->id)
                                    ->distinct('user_id')
                                    ->count('user_id');
        }

        return Inertia::render('Courses/UserCourses', [
            'courses' => $courses
        ]);
    }
}
