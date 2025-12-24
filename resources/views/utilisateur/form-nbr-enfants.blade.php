<h1>Formulaire pour la génération des cadeaux : </h1>

@if ($errors->any())
    <div style="color: red; margin-bottom: 1em;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('utilisateur.suggerer-cadeaux') }}">
    @csrf
    <div>
        <label for="filles">Nombre de filles</label>
        <input type="number" name="filles" id="filles" min="0" value="{{ old('filles', 0) }}">
    </div>
    <div>
        <label for="garcons">Nombre de garçons</label>
        <input type="number" name="garcons" id="garcons" min="0" value="{{ old('garcons', 0) }}">
    </div>
    <button type="submit">Envoyer</button>
</form>
