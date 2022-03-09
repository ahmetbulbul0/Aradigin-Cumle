<div class="outSmall2ListOneBox">
    <div class="inSmall2ListOneBox">
        <div class="outList">
            <div class="outTitle">
                <span class="inTitle">
                    <a href="{{ $data['smallList2One'][0]['allListLink'] }}">
                        {{ $data['smallList2One'][0]['listTitle'] }}
                    </a>
                </span>
            </div>
            <div class="inList">
                @foreach ($data['smallList2One'][0]['data'] as $news)
                    <div class="item">
                        <div class="content">
                            <a href="{{ route('haber_detay', [$news['link_url']]) }}">
                                {{ $news['content'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="outMore">
                    <a href="{{ $data['smallList2One'][0]['allListLink'] }}">Tüm Listeyi Görüntüle</a>
                </div>
            </div>
        </div>
        <div class="outList">
            <div class="outTitle">
                <span class="inTitle">
                    <a href="{{ $data['smallList2One'][1]['allListLink'] }}">
                        {{ $data['smallList2One'][1]['listTitle'] }}
                    </a>
                </span>
            </div>
            <div class="inList">
                @foreach ($data['smallList2One'][1]['data'] as $news)
                    <div class="item">
                        <div class="content">
                            <a href="{{ route('haber_detay', [$news['link_url']]) }}">
                                {{ $news['content'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="outMore">
                    <a href="{{ $data['smallList2One'][1]['allListLink'] }}">Tüm Listeyi Görüntüle</a>
                </div>
            </div>
        </div>
    </div>
</div>
