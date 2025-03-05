@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h3>{{ __('運営会社情報') }}</h3> <!-- Company Information -->
                    <p class="lead">会社の概要や連絡先情報をご覧いただけます。</p> <!-- View company overview and contact details -->
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>会社名:</strong> 株式会社サンプル</li>
                        <li class="list-group-item"><strong>所在地:</strong> 東京都千代田区1-2-3</li>
                        <li class="list-group-item"><strong>電話番号:</strong> 03-1234-5678</li>
                        <li class="list-group-item"><strong>Email:</strong> info@example.com</li>
                        <li class="list-group-item"><strong>設立:</strong> 2005年4月1日</li>
                        <li class="list-group-item"><strong>事業内容:</strong> ITサービス、ソフトウェア開発</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection