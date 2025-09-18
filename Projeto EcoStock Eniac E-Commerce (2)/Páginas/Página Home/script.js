// Scroll da navbar
window.addEventListener("scroll", () => {
  const navbar = document.querySelector(".navbar");
  navbar.classList.toggle("scrolled", window.scrollY > 10);
});

// Filtro por estado (qualidade)
const filtroQualidade = document.getElementById("filtroQualidade");
filtroQualidade.addEventListener("change", aplicarFiltros);

// Filtro por categoria
document.querySelectorAll(".cat").forEach(cat => {
  cat.addEventListener("click", e => {
    document.querySelectorAll(".cat").forEach(c => c.classList.remove("selected"));
    e.target.classList.add("selected");
    aplicarFiltros();
  });
});

// Função principal de filtro
function aplicarFiltros() {
  const categoriaSelecionada = document.querySelector(".cat.selected").dataset.cat;
  const qualidadeSelecionada = filtroQualidade.value;
  const cards = document.querySelectorAll(".card");

  cards.forEach(card => {
    const cardCategoria = card.dataset.cat;
    const cardQualidade = card.dataset.qualidade;
    const mostraCategoria = categoriaSelecionada === "all" || cardCategoria === categoriaSelecionada;
    const mostraQualidade = qualidadeSelecionada === "all" || cardQualidade === qualidadeSelecionada;

    card.style.display = (mostraCategoria && mostraQualidade) ? "block" : "none";
  });
}

// Adicionar ao carrinho
document.querySelectorAll(".btn").forEach(btn => {
  btn.addEventListener("click", e => {
    const card = e.target.closest(".card");
    const nome = card.querySelector("h3").innerText;
    const preco = parseFloat(card.dataset.preco);
    const imagem = card.querySelector("img").src;

    let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    const existente = carrinho.find(item => item.nome === nome);
    if (existente) {
      existente.quantidade += 1;
    } else {
      carrinho.push({ nome, preco, imagem, quantidade: 1 });
    }

    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    alert(`${nome} adicionado ao carrinho!`);
  });
});
