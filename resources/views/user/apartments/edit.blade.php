@extends('layouts.app')

@section('content')
    <h1 class="text-center">
        Modifica Appartamento
    </h1>
    <div class="container edit-container mt-5 w-50">
        <div class="edit">
            <div class="col-12">
                <h6>
                    Le foto del tuo appartamento:
                </h6>
            </div>
            @if (session('deleted-message'))
                <div class="mx-2 alert alert-success">
                    {{session('deleted-message')}}
                </div>
            @endif
                {{-- @dd($apartment->pictures) --}}
            <div class="col-12 d-flex flex-wrap mb-4">
                @foreach ($apartment->pictures as $photo)
                <div class="col-4 p-1 position-relative">
                    <div class="delete position-absolute">
                        <form action="{{route('picture.destroy',$photo)}}" method="POST" class="picture-form-destroyer" onclick="return confirm('Sei sicuro di voler eliminare la seguente foto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-1 delete">X</button>
                        </form>
                    </div>
                    @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                        <img class="rounded-1" src="{{$photo->image}}" alt="apartment img" >
                    @else
                        <img class="rounded-1" src="{{ asset('/storage') . '/' . $photo->image }}" alt="">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        <form class="row" action="{{ route('apartment.update', $apartment) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row apartment">
                <div class="col-12">
                    <label for="title">Titolo*</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $apartment->title }}" required autocomplete="on" autofocus minlength="5">
                    @error('title')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="image">Carica la foto cover:*</label>
                    <input type="file" name="image" id="image" value="{{ $apartment->image }}">
                    @error('image')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="description">Descrizione*</label>
                    <input class="form-control" type="text" name="description" id="description"
                        value="{{ $apartment->description }}" required autocomplete="on" autofocus minlength="10">
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_rooms">Numero di stanze:*</label>
                    <input type="number" name="n_rooms" id="n_rooms" value="{{ $apartment->n_rooms }}" required min="1">
                    @error('n_rooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_bedrooms">Numero di stanze da letto:*</label>
                    <input type="number" name="n_bedrooms" id="n_bedrooms" value="{{ $apartment->n_bedrooms }}" required min="1">
                    @error('n_bedrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_beds">Numero di letti:*</label>
                    <input type="number" name="n_beds" id="n_beds" value="{{ $apartment->n_beds }}" required min="1">
                    @error('n_beds')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_bathrooms">Numero di bagni:*</label>
                    <input type="number" name="n_bathrooms" id="n_bathrooms" value="{{ $apartment->n_bathrooms }}" required min="1">
                    @error('n_bathrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="guests">Numero massimo di ospiti:*</label>
                    <input type="number" name="guests" id="guests" value="{{ $apartment->guests }}" required min="1">
                    @error('guests')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                    <input type="checkbox" name="visible" id="visible" @if ($apartment->visible == 1) checked @endif>
                </div>
                <div class="col-12">
                    <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                    <input type="checkbox" name="available" id="available" @if ($apartment->available == 1) checked @endif>
                </div>
                <div class="col-12">
                    <label for="price">Inserisci il prezzo a notte per ospite:* </label>
                    <input type="number" name="price" id="price" value="{{ $apartment->price }}" required min="1">
                    @error('price')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="square_meters">Inserisci il numero di metri quadrati: </label>
                    <input type="number" name="square_meters" id="square_meters"
                        value="{{ $apartment->square_meters }}">
                    @error('square_meters')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address">inserisci la via:*</label>
                    <input class="w-100" type="text" name="address" id="address" value="{{ $apartment->address }}" required>
                    @error('address')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    <ul class="list-group" id="results">
                        <li class="list-group-item active d-none" id="1-result"></li>
                        <li class="list-group-item active d-none" id="2-result"></li>
                        <li class="list-group-item active d-none" id="3-result"></li>
                        <li class="list-group-item active d-none" id="4-result"></li>
                        <li class="list-group-item active d-none" id="5-result"></li>
                    </ul>
                </div>
                <div class="col-12 mb-3">
                    <label for="address_city">Servizi:*</label><br>
                    <div class="servizi d-flex flex-column flex-wrap">
                        @foreach ($services as $service)
                            <div class="service">
                                <input class="form-check-input ms-2" type="checkbox" name="service[]" value="{{ $service->id }}"
                                {{ $apartment->services->contains($service) ? 'checked' : '' }}>
                                <label for="categories">
                                    {{ $service->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('service')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <label for="image[]">inserisci altre foto del tuo appartamento</label>
                    {{-- @dd($apartment->pictures) --}}
                    <input type="file" class="form-control" name="images[]" id="image[]" multiple>
                </div>
                <div class="col-10 mt-3">
                    {{-- @foreach ($sponsorships as $sponsorship)
                        <div class="col-3">
                            <label for="sponsorship">{{ $sponsorship->name }}</label>
                            <input type="radio" name="sponsorship" id="sponsorship" value="{{ $sponsorship->id }}">
                        </div>
                    @endforeach --}}
                    <div class="Send my-auto">
                        <button class="btn btn-outline-primary btn-md" type="submit">send</button>
                    </div>

                </div>
            </div>
        </form>
        <div class="delete-button mt-2">
            @if (Auth::user()->id == $apartment->user_id)
                <form action="{{ route('apartment.destroy', $apartment->id) }}" method="POST" class="apartment-form-destroyer" onclick="return confirm('Sei sicuro di voler eliminare l\'appartamento {{$apartment->title}} ?' )">
                    {{-- apartment-title="{{ $apartment->title }}" --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md ms-auto">Delete</a>
                </form>
            @endif
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('js/tipsAddress.js') }}"></script>
@endsection
