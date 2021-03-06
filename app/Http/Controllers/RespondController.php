<?php

namespace App\Http\Controllers;

//use DB;
use Auth;
use App\Survey;
use App\Respond;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
class RespondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if($slug == NULL) {

            $responds = DB::table('responds')
                ->where('responds.user_id', '=', Auth::user()->id)
                ->join('surveys', 'responds.survey_id', '=', 'surveys.id')
                ->select('responds.*', 'surveys.title', 'surveys.description')->get();

            return response()->json([
                'message'=> 'success',
                'respondList' => $responds,
            ], 200);

        } else {

            if(Auth::user()) {

                $responds = DB::table('responds')
                    ->where('responds.survey_id', '=', Survey::where('slug', '=', $slug)->first()->id)
                    ->select('responds.ip_address', 'responds.created_at', 'responds.answer_ids')->get();

                for ($i=0; $i < count($responds); $i++) {

                    $currentAnswer_ids = explode("-", $responds[$i]->answer_ids);
                    for ($j=0; $j < count($currentAnswer_ids); $j++) {

                        $currentAnswerID = $currentAnswer_ids[$j];
                        $answer  = DB::table('answers')
                                        ->where('answers.id', '=', $currentAnswerID)
                                        ->join('contents', 'answers.content_id', '=', 'contents.id')
                                        ->select('answers.answer', 'contents.question')->get();

                        $questionString = $answer[0]->question;
                        $responds[$i]->$questionString = $answer[0]->answer;
                    }
                }

                return response()->json([
                    'message'=> 'success',
                    'respondList' => $responds,
                ], 200);

            } else {

                return abort(403);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function get_ip_address(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->secret === "1337_t0k3n") {

            $ip_addr = $this->get_ip_address();


            $respond = Respond::create([
                'ip_address'    => $ip_addr,
                'answer_ids'    => $request->answer_ids,
                'user_id'       => $request->idusu,
                'survey_id'     => $request->survey_id,
            ]);

            return response()->json([
                'message'=> 'success',
                'respond' => $respond,
            ], 200);

        } else {

            return abort(403);
        }
    }

    public function show($slug,$id)
    {
        $currentUser = Auth::user();
        $isFinished = false;
        $respond = null;


        /*try {

            $respond = Respond::where('survey_id', '=', Survey::where('slug', '=', $slug)->first()->id)
                ->firstOrFail();
            $isFinished = true;

        } catch(ModelNotFoundException $e) {

            $isFinished = false;
        }*/
        $data=DB::select("select * from responds r join surveys s on r.survey_id=s.id where s.slug='".$slug."' and r.user_id='".$id."'");
        if ($data==true){
            $isFinished=true;
        }
        return response()->json([
            'message'=> 'success',
            'isFinished' => $isFinished,
            'respond' => $respond,
            'dataTotal' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function edit(Respond $respond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Respond $respond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respond  $respond
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respond $respond)
    {
        //
    }
}
