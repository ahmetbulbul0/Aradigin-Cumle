<div class="outBigForm">
    <div class="inBigForm">
        <div class="outBigFormTitle">
            <span class="inBigFormTitle">
                Kategori Düzenle
            </span>
        </div>
        <div class="outBigFormContent">
            <form class="inBigFormContent" method="POST">
                <div class="line">
                    <span class="inputLabel">Kategori Adı:</span>
                    <div class="outInputText">
                        <input type="text" name="name" value="{{ Str::title($data['data']['name']) }}"
                            placeholder="Kategori adı...">
                    </div>
                </div>
                @isset($data['errors']['name'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['name'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                <div class="line">
                    <span class="inputLabel">Kategori Tipi:</span>
                    <div class="outSelectBox">
                        <select name="type">
                            <option disabled>Kategori Tipi Seç</option>
                            @foreach ($data['categoryTypes'] as $categoryTypes)
                                <option value="{{ $categoryTypes['no'] }}"  @if ($categoryTypes['no'] == $data['data']['type']["no"]) selected @endif>{{ Str::title($categoryTypes['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @isset($data['errors']['type'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['type'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                <div class="line">
                    <span class="inputLabel">Ana Kategori:</span>
                    <div class="outSelectBox">
                        <select name="mainCategory">
                            <option value="default" @empty($data['data']['mainCategory']) selected @endempty disabled>Ana Kategoriyi Seç (Alt Kategori Ekliyorsanız)</option>
                            @foreach ($data['categories'] as $categories)
                                <option value="{{ $categories['no'] }}" @isset ($data['data']['main_category']["no"]) @if ($categories['no'] == $data['data']['main_category']["no"]) selected @endif @endisset>{{ Str::title($categories['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @isset($data['errors']['mainCategory'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['mainCategory'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                @csrf
                <div class="line">
                    <div class="outSubmitBox">
                        <button>
                            İşlemi Tamamla
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
