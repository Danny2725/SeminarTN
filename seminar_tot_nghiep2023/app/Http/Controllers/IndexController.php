<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\PostModel;
use App\Models\caulacboModel;
use App\Models\baiviet_Model;
use App\Models\ThanhVienModel;
use App\Models\CLB_Model;
use App\Models\images_Post_Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;




class IndexController extends Controller
{
    // gọi model PostModel, CLB_Model về index (gồm có slide, posts, tên clb)
    public function show()
    {
    }
    //search
    public function search(Request $request)
    {
        // slide, tên clb
        $data1 = CLB_Model::all();
        //search
        $search = $request->search;
        $dateFilter = $request->date_filter;  //filter ngày tháng cho bài posts 
        $selectedClub = $request->club_filter;   //lọc câu lạc bộ
        $query = PostModel::query()
            ->Where(function ($query) use ($search) {
                $query->where('post_content', 'like', "%$search%");
            })
            ->Where(function ($query) use ($dateFilter) {
                switch ($dateFilter) {
                    case 'day':
                        $query->whereDate('created_time', Carbon::today());
                        break;
                    case 'week':
                        $query->whereBetween('created_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_time', Carbon::now()->month);
                        break;
                    case 'year':
                        $query->whereYear('created_time', Carbon::now()->year);
                        break;
                }
            })
            ->Where(function ($query) use ($selectedClub) {
                switch ($selectedClub) {
                    case 'hcmusec':
                        $query->where('fanpage_name', 'hcmusec');
                        break;
                    case 'escussh':
                        $query->where('fanpage_name', 'escussh');
                        break;

                }
            });
        $data = $query->get()->sortByDesc('created_time');
        return view('frontend.index', compact('data', 'search', 'data1', 'dateFilter', 'selectedClub'));
    }



    // chi tiết bài posts
    function show1($postId)
    {
        $data1 = CLB_Model::all();
        $post = PostModel::find($postId);
        $post_2 =  PostModel::find($postId)->getImages_Null;
        $post_1 = PostModel::find($postId)->getImages_Post;
        return view('frontend.baiviet', compact('post', 'post_1', 'post_2','data1' ));
    }

    //chi tiết trang giới thiệu
    public function gioithieu($gioithieuId)
    {
        $data1 = CLB_Model::all();

        $gioithieu = caulacboModel::find($gioithieuId)->getThanhVien;
        $gioithieu1 = CLB_Model::find($gioithieuId);
        return view('frontend.gioithieu', compact('gioithieu', 'gioithieu1', 'data1'));
    }
}
