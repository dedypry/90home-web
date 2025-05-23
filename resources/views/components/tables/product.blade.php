<style>
    .text-img p {
        padding: 0px;
        margin: 0px;
    }

    .con-img {
        display: flex;
        gap: 10px;
        align-items: center
    }
</style>
<div style="padding: 10px">
    @php
    $product = json_decode($getState());
    $record = $getRecord();
// dd($product);
    @endphp
    <div class="con-img">
        <img src="{{asset('storage/'.$product->images[0])}}" alt="" style="height: 100px">

        <div class="text-img">
            <p>{{$product->cluster}}</p>
            <p style="font-weight: bold; font-style: italic">Rp. {{numFormat($record->price)}}</p>
        </div>
    </div>
</div>
