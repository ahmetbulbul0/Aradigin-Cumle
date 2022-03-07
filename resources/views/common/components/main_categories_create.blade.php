<div class="bar">
    <div class="line title">
        <span class="title">
            Ana Kategori Kontrölü (Sabitler)
        </span>
    </div>
    @foreach ($data['main_categories']['constants'] as $constant)
        <div class="line">
            <div class="outLabel">
                <label>{{ $constant['name'] }}:</label>
            </div>
            <div class="outSpan">
                <span>
                    @if ($constant['value'])
                        Mevcut <i class="fa-solid fa-circle-check green"></i>
                    @else
                        Tanımlanmamış <i class="fa-solid fa-circle-exclamation red"></i>
                    @endif
                </span>
            </div>
        </div>
    @endforeach
</div>
<div class="bar">
    <div class="line title">
        <span class="title">
            Ana Kategori Oluşturma
        </span>
    </div>
    @foreach ($data['main_categories']['constants'] as $constant)
        <form action="{{ route('api_website_kurulum_asama_4') }}" method="POST"
            class="line @if (!$constant['value']) buttonWithInputText @endif @if (!$constant['value']) labelWithInputText @endif">
            <div class="outLabel">
                <label>{{ $constant['name'] }}:</label>
            </div>
            @if (!$constant['value'])
                <div class="outInputText">
                    <input type="text" name="categoryName" required>
                </div>
                @csrf
                <div class="outButton">
                    <button name="actionType" value="{{ $constant['create'] }}">Oluştur</button>
                </div>
            @endif
            @if ($constant['value'])
                <div class="outInputText">
                    <input type="text" name="category" value="{{ Str::title($constant['value']['name']) }}" disabled>
                </div>
            @endif
        </form>
    @endforeach
</div>