
"use strict";

const data = [
  {
    titulo: "Conversión y cálculos numéricos",
    contenido: [
      ["parseInt()", 'parseInt("10")', "Convierte texto a número entero."],
      ["parseFloat()", 'parseFloat("3.14")', "Convierte texto a número decimal."],
      ["Number()", 'Number("5")', "Convierte texto o booleano a número."],
      ["isNaN()", 'isNaN("hola")', "Comprueba si un valor no es numérico."],
      ["toFixed()", "(3.1416).toFixed(2)", "Redondea y devuelve número con decimales fijos."],
      ["Math.random()", "Math.random()", "Genera un número aleatorio entre 0 y 1."],
      ["Math.floor()", "Math.floor(4.9)", "Redondea hacia abajo."],
      ["Math.ceil()", "Math.ceil(4.1)", "Redondea hacia arriba."],
      ["Math.round()", "Math.round(4.6)", "Redondea al entero más cercano."],
      ["Math.trunc()", "Math.trunc(4.9)", "Elimina los decimales sin redondear."],
      ["Math.max()", "Math.max(2,5,1)", "Devuelve el número mayor."],
      ["Math.min()", "Math.min(2,5,1)", "Devuelve el número menor."],
      ["Math.pow()", "Math.pow(2,3)", "Calcula potencias."],
      ["Math.sqrt()", "Math.sqrt(9)", "Calcula raíz cuadrada."],
      ["Math.PI", "Math.PI", "Constante del número π."]
    ]
  },
  {
    titulo: "Control de flujo y estructuras",
    contenido: [
      ["if / else", "if(cond){...} else {...}", "Ejecuta código según condición."],
      ["switch", "switch(valor){case x:...}", "Selecciona entre varias opciones."],
      ["for", "for(i=0;i<5;i++)", "Repite un bloque de código."],
      ["for...of", "for(let e of a)", "Recorre directamente los valores de un array."],
      ["while", "while(cond){...}", "Repite mientras se cumpla condición."],
      ["do...while", "do{...}while(cond)", "Ejecuta una vez antes de comprobar la condición."],
      ["break", "break;", "Sale de un bucle o switch."],
      ["continue", "continue;", "Salta a la siguiente iteración."]
    ]
  },
  {
    titulo: "Arrays — creación y manipulación básica",
    contenido: [
      ["[]", 'let frutas = ["Melón","Kiwi"]', "Crea un array con elementos."],
      ["new Array()", "new Array(5)", "Crea array con tamaño predefinido."],
      [".fill()", "new Array(3).fill(0)", "Rellena el array con un valor."],
      ["...spread", "let b = [...a]", "Copia o combina arrays."],
      ["a[i]", 'a[2] = "Uva"', "Accede o modifica por índice."],
      [".at()", "a.at(-1)", "Accede con índice positivo o negativo."],
      [".length", "a.length", "Muestra o cambia longitud del array."]
    ]
  },
  {
    titulo: "Añadir y eliminar elementos",
    contenido: [
      [".push()", 'a.push("Sandía")', "Añade al final."],
      [".pop()", "a.pop()", "Elimina el último."],
      [".unshift()", 'a.unshift("Kiwi")', "Añade al inicio."],
      [".shift()", "a.shift()", "Elimina el primero."],
      [".splice()", 'a.splice(2,1,"Nuevo")', "Elimina o sustituye elementos (modifica el array)."],
      ["delete a[i]", 'delete a[1]', "Elimina sin cambiar tamaño (deja hueco)."]
    ]
  },
  {
    titulo: "Recorrer y transformar arrays",
    contenido: [
      ["for", "for(let i=0;i<a.length;i++)", "Recorre usando índice."],
      ["for...of", "for(let e of a)", "Recorre valores directamente."],
      [".forEach()", "a.forEach(e=>console.log(e))", "Ejecuta código por elemento."],
      [".map()", "a.map(e=>e*2)", "Crea un nuevo array transformado."],
      [".flat()", "[1,[2,[3]]].flat(2)", "Aplana arrays anidados."]
    ]
  },
  {
    titulo: "Métodos comunes de arrays",
    contenido: [
      [".join()", 'a.join(",")', "Une elementos en un texto."],
      [".reverse()", "a.reverse()", "Invierte el orden (modifica)."],
      [".toReversed()", "a.toReversed()", "Devuelve copia invertida."],
      [".concat()", "a.concat(b,[1,2])", "Une arrays."],
      [".fill()", "a.fill(5)", "Rellena con un valor."]
    ]
  },
  {
    titulo: "Búsqueda y comprobaciones",
    contenido: [
      [".includes()", 'a.includes("gato")', "Devuelve true si existe."],
      [".indexOf()", 'a.indexOf("Zorro")', "Devuelve índice del valor."],
      [".find()", "a.find(e => e > 10)", "Primer valor que cumple condición."],
      [".findIndex()", "a.findIndex(e => e > 10)", "Índice del primer valor que cumple."],
      [".some()", "a.some(e => e > 10)", "true si alguno cumple."],
      [".every()", "a.every(e => e > 10)", "true si todos cumplen."]
    ]
  },
  {
    titulo: "Ordenar, cortar y sustituir",
    contenido: [
      [".sort()", "a.sort((x,y)=>x-y)", "Ordena (modifica)."],
      [".toSorted()", "a.toSorted((x,y)=>x-y)", "Devuelve copia ordenada."],
      [".slice()", "a.slice(1,4)", "Corta sin modificar."],
      [".splice()", 'a.splice(2,1,"Nuevo")', "Elimina o reemplaza (modifica)."],
      [".toSpliced()", "a.toSpliced(2,1)", "Elimina sin modificar el original."]
    ]
  },
  {
    titulo: "Métodos funcionales avanzados",
    contenido: [
      [".filter()", "a.filter(x=>x>3)", "Filtra los elementos que cumplan."],
      [".reduce()", "a.reduce((a,b)=>a+b)", "Suma o combina valores."]
    ]
  },
  {
    titulo: "Copiar, combinar y crear arrays",
    contenido: [
      ["...spread", "[...a, ...b]", "Copia o combina arrays."],
      [".concat()", "a.concat(b)", "Une arrays sin modificar."],
      ["[,,,,]", "[,,,,]", "Crea array con huecos vacíos."],
      ["new Array(n)", "new Array(5)", "Crea array con longitud fija."],
      [".fill()", "new Array(7).fill(7)", "Rellena con un mismo valor."]
    ]
  },
  {
    titulo: "Cadenas de texto (Strings)",
    contenido: [
      [".split()", '"hola mundo".split(" ")', "Divide texto en partes."],
      [".toLowerCase()", '"HOLA".toLowerCase()', "Convierte a minúsculas."],
      [".toUpperCase()", '"hola".toUpperCase()', "Convierte a mayúsculas."],
      [".trim()", '" hola ".trim()', "Quita espacios."],
      [".match()", '"abc123".match(/\\d+/)', "Busca con expresiones regulares."],
      [".concat()", '"Hola".concat(" mundo")', "Une cadenas."],
      [".replace()", '"hola".replace("o","a")', "Sustituye texto."],
      [".slice()", '"Hola".slice(1)', "Extrae parte del texto."],
      [".charAt()", '"Hola".charAt(0)', "Devuelve carácter por índice."],
      [".includes()", '"Hola".includes("la")', "Comprueba si contiene texto."]
    ]
  },
  {
    titulo: "Funciones",
    contenido: [
      ["function", "function sumar(a,b){return a+b}", "Declara una función clásica."],
      ["const f = ()=>{}", "const f = a => a*2", "Función flecha."],
      ["arguments", "arguments.length", "Lista de parámetros recibidos."],
      ["...rest", "function f(a,...rest){}", "Agrupa parámetros en array."],
      ["valores por defecto", "function f(a,b=1){}", "Asigna valor si no se pasa."],
      ["return", "return valor", "Devuelve un valor desde la función."]
    ]
  },
  {
    titulo: "Entrada y salida de datos",
    contenido: [
      ["prompt()", 'prompt("Mensaje")', "Solicita datos al usuario."],
      ["alert()", 'alert("Hola")', "Muestra mensaje emergente."],
      ["console.log()", 'console.log("texto")', "Muestra texto en consola."]
    ]
  },
  {
    titulo: "Tipos, objetos y propiedades",
    contenido: [
      ["typeof", "typeof 5", "Devuelve tipo de dato."],
      ["instanceof", "obj instanceof Array", "Comprueba tipo de objeto."],
      ["Object.keys()", "Object.keys(persona)", "Devuelve las claves del objeto."],
      ["Object.values()", "Object.values(persona)", "Devuelve valores del objeto."],
      ["Object.entries()", "Object.entries(persona)", "Devuelve pares clave–valor."],
      ["const / let / var", "const x=1; let y=2", "Declaran variables."]
    ]
  }
];

// Render dinámico
document.addEventListener("DOMContentLoaded", () => {
  const main = document.getElementById("content");
  const asideList = document.getElementById("sectionList");

  data.forEach((seccion, index) => {
    const sectionId = `seccion-${index}`;
    const section = document.createElement("section");
    section.classList.add("section");
    section.id = sectionId;

    const title = document.createElement("h2");
    title.textContent = seccion.titulo;
    section.appendChild(title);

    const table = document.createElement("table");
    table.innerHTML = `<thead><tr><th>Función / Método</th><th>Cómo se usa</th><th>Para qué sirve</th></tr></thead>`;
    const tbody = document.createElement("tbody");

    seccion.contenido.forEach(fila => {
      const tr = document.createElement("tr");
      fila.forEach(celda => {
        const td = document.createElement("td");
        td.textContent = celda;
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });

    table.appendChild(tbody);
    section.appendChild(table);
    main.appendChild(section);

    const li = document.createElement("li");
    const a = document.createElement("a");
    a.href = `#${sectionId}`;
    a.textContent = seccion.titulo;
    li.appendChild(a);
    asideList.appendChild(li);
  });

  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("input", (e) => {
    const term = e.target.value.toLowerCase().trim();
    let found = false;
    let foundSection = null;
    let foundRow = null;

    // Quitar destacado previo
    document.querySelectorAll(".highlight-row").forEach(row => row.classList.remove("highlight-row"));

    if (term.length < 2) return; // No buscar palabras de 1 letra

    // Buscar en todas las tablas y marcar el primero que encuentre (mejor experiencia UX)
    document.querySelectorAll("section").forEach(section => {
      section.querySelectorAll("tbody tr").forEach(tr => {
        if (tr.textContent.toLowerCase().includes(term) && !found) {
          tr.classList.add("highlight-row");
          found = true;
          foundSection = section;
          foundRow = tr;
        }
      });
    });

    // Si hay resultado, hacer scroll suave a la sección y luego centrar la fila destacada
    if (foundSection && foundRow) {
      foundSection.scrollIntoView({behavior: "smooth", block: "start"});
      setTimeout(() => { foundRow.scrollIntoView({behavior: "smooth", block: "center"}); }, 400);
    }
  });
});
