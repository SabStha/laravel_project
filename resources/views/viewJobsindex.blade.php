@extends('layouts.header')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h2 class="fw-bold">{{ __('あなたの求人一覧') }}</h2>
                    <p class="lead mb-0">あなたが投稿した求人を管理します。</p>
                </div>

                <div class="card-body">
                    @if($jobs->isEmpty())
                        <p class="text-center">求人が見つかりません。 <a href="{{ route('jobs_create') }}">求人を作成する</a></p>
                    @else
                        <table class="table table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>タイトル</th>
                                    <th>カテゴリー</th>
                                    <th>勤務地</th>
                                    <th>投稿日</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->category->name ?? 'カテゴリーなし' }}</td>

                                        <td>{{ $job->location }}</td>
                                        <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-info">詳細</a>
                                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">編集</a>
                                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
