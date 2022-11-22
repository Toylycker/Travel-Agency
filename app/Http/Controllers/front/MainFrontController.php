<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Day;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\Place;
use App\Models\Post;
use App\Models\ReceivedMessage;
use App\Models\Subject;
use App\Models\Tour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainFrontController extends Controller
{
    public function index()
    {
        return Inertia::render('front/Welcome');
    }

    public function places(Request $request)
    {
        $request->validate([
            'search'=>'nullable|string|max:10',
            'category' =>'nullable|string|max:15'
        ]);
        $search = ($request->search)?$request->search:null;
        $category = ($request->category)?Category::where('name', $request->category)->first():null;
        $location = ($request->location)?Location::findOrFail($request->location):null;

        $locations = Location::has('places')->get();
        $places = Place::when($location, function ($query,$location){
            $query->whereHas('location', function ($query) use ($location){
                $query->where('id', $location->id);
            });
        })
        ->when($category, function ($query,$category){
            $query->whereHas('categories', function ($query) use ($category){
                $query->where('name', $category->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where('name', 'like', '%' . $search . '%');
        })->with('images', 'texts')->paginate( 10, ['id', 'name', 'body'])->withQueryString();
        return Inertia::render('front/Places', [
            'places'=> $places,
            'title' => 'The Best PLace In The World',
            'search' => $search,
            'category' => $category?$category->name:null,
            'location' => $location,
            'categories'=>Category::get(),
            'locations'=>$locations,
            'show' => $places->count()>0?true:false,
            'potentialSearchResultLength' =>$request->count?$request->count:null
        ]);
    }

    public function tours()
    {
        $tours = Tour::with(['days'=> function($query){
            $query->withCount('places');
        }, 'days.places'])->paginate(4);
        return Inertia::render('front/Tours', compact('tours'));
    }

    public function showtour($id){
        $tour = Tour::findOrFail($id);
        $tour = Tour::where('id', $id)->with('notes', 'prices', 'images')->first();
        $days = Day::where('tour_id', $tour->id)->with(['places', 'hotels'])->orderBy('day_number')->get();
        return Inertia::render('front/ShowTour', ['tour'=>$tour, 'days'=>$days]);
    }

    public function showPost($id)
    {
        $post = Post::where('id', $id)->with(['texts', 'images'])->first();
        return Inertia::render('front/ShowPost', ['post'=>$post]);
    }

    public function showplace($id){
        $place = PLace::findOrFail($id);
        $place = Place::where('id', $id)->with('texts.images', 'images', 'links')->first();
        return Inertia::render('front/ShowPlace', ['place'=>$place]);
    }

    public function blog(Request $request)
    {
        $request->validate([
            'search'=>'nullable|string|max:10',
            'subject' =>'nullable|max:15'
        ]);

        // return $request;

        $search = ($request->search)?$request->search:null;
        $subject = ($request->subject)?Subject::findOrFail($request->subject):null;

        $posts = Post::when($subject, function ($query,$subject){
            $query->whereHas('subjects', function ($query) use ($subject){
                $query->where('name', $subject->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where(function ($query)use ($search){
                $query->where('title', 'like', '%' . $search . '%');
                $query->orWhere('body', 'like', '%' . $search . '%');
            });
        })
        ->with('images', 'texts', 'videos')
        ->paginate( 10, ['id', 'title', 'body', 'main_image'])->withQueryString();

        $subjects=Subject::when($subject, function ($query,$subject){
            $query->whereNot('id', $subject->id);
        })->get();

        return Inertia::render('front/Blog', [
            'posts'=> $posts,
            'search' => $search,
            'subject' => $subject,
            'subjects'=>$subjects,
            'show' =>$posts->count()>0?true:false
        ]);
    }

    public function hotels(Request $request)
    {
        $request->validate([
            'location' => 'numeric|nullable'
        ]);
        $location = $request->location?Location::findOrFail($request->location):null;
        $hotels = Hotel::with('images', 'rooms')->when($location, function ($query) use ($location){
            $query->where('location_id', $location->id);
        })->
        paginate(6)->withQueryString();
        $locations = Location::has('hotels')->get();
        return Inertia::render('front/Hotels', ['hotels'=>$hotels, 'locations'=>$locations, 'location'=>$location?$location->id:0]);
    }

    public function contact()
    {
        return Inertia::render('front/ContactUs');
    }

    public function resultlength(Request $request){
        $request->validate([
            'search'=>'nullable|string|max:10',
            'category' =>'nullable|string|max:15',
            'location' =>'nullable'
        ]);
        $search = ($request->search)?$request->search:null;
        $category = ($request->category)?Category::where('name', $request->category)->first():null;
        $location = ($request->location)?location::findOrFail($request->location):null;

        $places = Place::when($location, function ($query,$location){
            $query->whereHas('location', function ($query) use ($location){
                $query->where('id', $location->id);
            });
        })
        ->when($category, function ($query,$category){
            $query->whereHas('categories', function ($query) use ($category){
                $query->where('name', $category->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where('name', 'like', '%' . $search . '%');
        });
        
        return Inertia::render('front/Places', [
            'potentialSearchResultLength' =>$places->count()
        ]);


    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'email'=>'email|required',
            'message'=>'string|required'
        ]);

        ReceivedMessage::create(['email'=>$request->email, 'message'=>$request->message]);

        return Redirect()->back();

    }
}
