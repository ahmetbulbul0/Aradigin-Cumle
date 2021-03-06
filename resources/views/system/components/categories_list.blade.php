<div class="outDbList">
    <div class="inDbList">
        <div class="outTitle">
            <div class="inTitle">
                Kategoriler
            </div>

            <div class="titleSelects">
                <div class="actions">
                    <a href="{{ route('kategori_ekle') }}" target="blank">Yeni Kategori Oluştur</a>
                </div>
                <div class="listingTypeSelect">
                    <form method="POST" class="outSelectBox">
                        @csrf
                        <select name="listingType" onchange="if(this.value != 0) { this.form.submit(); }">
                            <option value="default" @if (Route::is('kategoriler')) selected @endif>Varsayılan</option>
                            <option value="no09" @if (Route::is('kategoriler_no09')) selected @endif>No (0 - 9)</option>
                            <option value="no90" @if (Route::is('kategoriler_no90')) selected @endif>No (9 - 0)</option>
                            <option value="nameAZ" @if (Route::is('kategoriler_nameAZ')) selected @endif>Ad (A - Z)</option>
                            <option value="nameZA" @if (Route::is('kategoriler_nameZA')) selected @endif>Ad (Z - A)</option>
                            <option value="typeAZ" @if (Route::is('kategoriler_typeAZ')) selected @endif>Tip (A - Z)</option>
                            <option value="typeZA" @if (Route::is('kategoriler_typeZA')) selected @endif>Tip (Z - A)</option>
                            <option value="mainCategoryAZ" @if (Route::is('kategoriler_mainCategoryAZ')) selected @endif>Ana Kategori (A - Z)</option>
                            <option value="mainCategoryZA" @if (Route::is('kategoriler_mainCategoryZA')) selected @endif>Ana Kategori (Z - A)</option>
                            <option value="linkUrlAZ" @if (Route::is('kategoriler_linkUrlAZ')) selected @endif>Link Metni (A - Z)</option>
                            <option value="linkUrlZA" @if (Route::is('kategoriler_linkUrlZA')) selected @endif>Link Metni (Z - A)</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="dbList">
            <div class="titleLine">
                <div class="w20">
                    <span>No</span>
                </div>
                <div class="w20">
                    <span>Ad</span>
                </div>
                <div class="w20">
                    <span>Tip</span>
                </div>
                <div class="w20">
                    <span>Ana Kategori</span>
                </div>
                <div class="w20">
                    <span>Link Metni</span>
                </div>
                <div class="w20">
                    <span>İşlem</span>
                </div>
            </div>
            @foreach ($data['data'] as $item)
                <div class="line">
                    <div class="w20">
                        <span>{{ $item['no'] }}</span>
                    </div>
                    <div class="w20">
                        <span>{{ $item['name'] }}</span>
                    </div>
                    <div class="w20">
                        <span>{{ $item['type']['name'] }}</span>
                    </div>
                    <div class="w20">
                        <span>{{ $item['main_category']['name'] ?? '-' }}</span>
                    </div>
                    <div class="w20">
                        <span>{{ $item['link_url'] }}</span>
                    </div>
                    <div class="actions w20">
                        <span>
                            <a href="/sistem-paneli/kategori/düzenle/{{ $item['no'] }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/sistem-paneli/kategori/sil/{{ $item['no'] }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
