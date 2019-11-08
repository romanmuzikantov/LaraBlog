@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Erreur(s)!</h4>
        <p>Veuillez corriger ces erreurs avant de renvoyer le formulaire</p>
        <hr>
        <ul class="mt-4">
            @foreach ($errors->all() as $error)
                <li class="mb-0">
                    <p class="mb-1">{{ $error }}</p>    
                </li>
            @endforeach
        </ul>
        
    </div>
@endif