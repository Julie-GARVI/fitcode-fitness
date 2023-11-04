<script>
  
  import Router, { location } from "svelte-spa-router";
  import routes from "./routes.js";
  
  import Header from "./layout/Header.svelte";
  import Footer from "./layout/Footer.svelte";

  import { beforeUpdate } from "svelte";
  
const currentPath = window.location.href;

  beforeUpdate(() => {
    $location === "/"
      ? document.body.classList.add("homepage")
      : document.body.classList.remove("homepage");
  });

</script>


  <Header />

<main>

  <Router {routes} />

</main>

  <Footer />