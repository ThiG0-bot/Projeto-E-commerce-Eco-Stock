document.addEventListener("DOMContentLoaded", () => {
  const lista = document.getElementById("carrinho-lista");
  const totalEl = document.getElementById("total");

  let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  function atualizarCarrinho() {
    lista.innerHTML = "";
    let total = 0;

    carrinho.forEach((item, i) => {
      total += item.preco * item.quantidade;

      let li = document.createElement("li");
      li.innerHTML = `
        <img src="${item.imagem}" alt="${item.nome}" width="60">
        <span>${item.nome} - R$ ${item.preco.toFixed(2)}</span>
        <input type="number" min="1" value="${item.quantidade}" data-index="${i}">
        <button class="remover" data-index="${i}">❌</button>
      `;
      lista.appendChild(li);
    });

    totalEl.textContent = total.toFixed(2);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
  }

  // Alterar quantidade
  lista.addEventListener("input", e => {
    if (e.target.type === "number") {
      let i = e.target.dataset.index;
      carrinho[i].quantidade = parseInt(e.target.value);
      atualizarCarrinho();
    }
  });

  // Remover item
  lista.addEventListener("click", e => {
    if (e.target.classList.contains("remover")) {
      let i = e.target.dataset.index;
      carrinho.splice(i, 1);
      atualizarCarrinho();
    }
  });

  // Botão pagar
  document.getElementById("btn-pagar").addEventListener("click", () => {
    alert("Indo para a página de pagamento...");
    window.location.href = "pagamento.html";
  });

  atualizarCarrinho();
});
