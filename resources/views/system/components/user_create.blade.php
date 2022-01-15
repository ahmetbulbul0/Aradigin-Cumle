<div class="outNewsCreate">
    <div class="inNewsCreate">
        <div class="outNewsCreateTitle">
            <span class="inNewsCreateTitle">
                Kullanıcı Ekle
            </span>
        </div>
        <div class="outNewsCreateForm">
            <form class="inNewsCreateForm" method="POST">
                <div class="line">
                    <span class="inputLabel">Tam Adı:</span>
                    <div class="outInputText">
                        <input type="text" name="fullName" placeholder="Tam Adı...">
                    </div>
                </div>
                @isset($data['errors']['fullName'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['fullName'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                <div class="line">
                    <span class="inputLabel">Kullanıcı Adı:</span>
                    <div class="outInputText">
                        <input type="text" name="username" placeholder="Kullanıcı Adı...">
                    </div>
                </div>
                @isset($data['errors']['username'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['username'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                <div class="line">
                    <span class="inputLabel">Parola:</span>
                    <div class="outInputText">
                        <input type="text" name="password" placeholder="Parola...">
                    </div>
                </div>
                @isset($data['errors']['password'])
                    <div class="line">
                        <div class="outErrorBox">
                            <span>
                                {{ $data['errors']['password'] }}
                            </span>
                        </div>
                    </div>
                @endisset
                <div class="line">
                    <span class="inputLabel">Kullanıcı Tipi:</span>
                    <div class="outSelectBox">
                        <select name="type">
                            <option selected disabled>Kullanıcı Tipi Seç</option>
                            @foreach ($data['userTypes'] as $userType)
                                <option value="{{ $userType['no'] }}">{{ $userType['name'] }}</option>
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