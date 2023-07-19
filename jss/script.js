// Función para obtener la lista de Pokémon desde la PokeAPI
function getPokemonList() {
  fetch('https://pokeapi.co/api/v2/pokemon?limit=1010')
    .then(response => response.json())
    .then(data => {

      // Recorre la lista de Pokémon y crea botones para cada uno
      data.results.forEach(pokemon => {
        const pokemonButton = document.createElement('button');
        pokemonButton.textContent = `#${pokemon.url.split('/')[6]} - ${pokemon.name.toUpperCase()}`; //Pone el "#" y sus nombres en mayúscula
        pokemonButton.addEventListener('click', () => redirectToPokemonPage(pokemon.name));
        pokemonList.appendChild(pokemonButton);
      });
    })
    .catch(error => {
      console.log(error);
    });
}

// Llama a la función para obtener la lista de Pokémon
getPokemonList();


// Obtiene la referencia al elemento con el ID "pokemonList" en el HTML
const pokemonList = document.getElementById('pokemonList');

// Función para obtener la información de un Pokémon específico
function getPokemonData(pokemonName) {
  fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`)
    .then(response => response.json())
    .then(data => {
      const pokemonData = document.getElementById('pokemonData');

      // Crea elementos HTML para mostrar la información y estadísticas del Pokémon
      const name = document.createElement('h2'); //El elemento h2 se almacenará en la variable "name"
      name.textContent = data.name; // Se establece el contenido del texto con el valor "data.name", ese el nombre del Pokémon que se obtiene de la API 
      pokemonData.appendChild(name); // Se agrega "name" (h2) como hijo del elemento con el ID "pokemonData" y esta variable almacena otra referencia a este elemento, en este caso el nombre del pokemon

      //Todos los demás tienen basicamente la misma estructura...

      //Sprites/Imágenes
      const sprite = document.createElement('img');
      sprite.src = data.sprites.front_default;
      pokemonData.appendChild(sprite);

      //Tipo del pokemon
      const typesTitle = document.createElement('h4');
      typesTitle.textContent = 'Types:';
      pokemonData.appendChild(typesTitle);

      //Para poner los elementos/Tipos del pokemón
      data.types.forEach(type => {
        const typeSpan = document.createElement('span');
        typeSpan.textContent = type.type.name;
        typeSpan.classList.add('pokemon-type');
        pokemonData.appendChild(typeSpan);
      });

      //Stats/Estadísticas
      const statsTitle = document.createElement('h3');
      statsTitle.textContent = 'Stats:';
      pokemonData.appendChild(statsTitle);

      //Lista de los Stats del pokemon
      const statsList = document.createElement('ul');
      data.stats.forEach(stat => {
        const statItem = document.createElement('li');
        statItem.textContent = `${stat.stat.name}: ${stat.base_stat}`;
        statsList.appendChild(statItem);
      });
      pokemonData.appendChild(statsList);
    })

    // Captura cualquier error que ocurra durante la solicitud de la API, lo muestra en la consola del navegador
    .catch(error => {
      console.log(error);
    });
}

// Obtiene el nombre del Pokémon de la URL y llama a la función para obtener su información
const urlParams = new URLSearchParams(window.location.search);
const pokemonName = urlParams.get('name');
getPokemonData(pokemonName);


// Función para redirigir a la página de información del Pokémon
function redirectToPokemonPage(pokemonName) {
  window.location.href = `pokemon.html?name=${pokemonName}`;
}


