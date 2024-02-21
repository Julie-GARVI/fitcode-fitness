
@php require_once("../resources/views/header.blade.php"); @endphp

<h1>Contact adhérent</h1>

<main class="contact-wrapper">

    <section class="container-contact">

     <h2>.. Résultats</h2>

     @foreach ($contacts as $contact)
     <div class="contact-block">
        <div class="username">
            <div class="credentials">
                <p>{{$contact->lastname}} <span class="firstname"> {{$contact->firstname}} </span></p>
            </div>
            <p><i class="fa-solid fa-paper-plane pink"></i>{{$contact->email}}</p>
        </div>
        <div class="message">
            <p>{{$contact->message}}<p>
        <div class="icon">
            <i class="fa-solid fa-user"></i>
        </div>
        </div>
     </div>

     @endforeach
    </section>

</main>