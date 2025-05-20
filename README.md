# Heart LinkedIn

**Autor:** Rafy Co.  
**Versão:** 0.1.0  
**Licença:** GPLv2 ou posterior  
**Requer WordPress:** 6.0+  
**Testado até:** 6.5  
**Tags:** linkedin, bloco, like, coração, comentário, interação  
**Namespace PHP:** `RafyCo\HeartLinkedin`

---

## Descrição

O **Heart LinkedIn** adiciona um bloco visual ao editor Gutenberg que permite:

- Exibir um botão de "Curtir" com ícone de coração (interativo).
- Mostrar um botão de comentário no LinkedIn com link personalizado.
- Integrar diretamente com campos personalizados (`likes` e `in_post`) via ACF.
- Registrar curtidas (likes) por usuários autenticados via REST API.
- Redirecionar visitantes para `/assinatura` ao tentar curtir sem login.

Totalmente compatível com o editor de blocos, segue os padrões de codificação do WordPress e boas práticas modernas de segurança e organização.

---

## Funcionalidades

✅ Bloco com estrutura HTML estilizada  
✅ Ícone de coração interativo com 3 estados: vazio, vermelho e preto (hover)  
✅ Integração com campos ACF do tipo relacionamento  
✅ Integração com campo personalizado para link do post no LinkedIn  
✅ REST API para registrar likes/deslikes com segurança baseada em token e nonce  
✅ Script JavaScript modular e CSS separado  
✅ Página de configurações com campo de token  
✅ Shortcode `[heart_linkedin]` para usar o bloco via código

---

## Instalação

1. Faça o upload da pasta do plugin para o diretório `wp-content/plugins/` ou instale via painel do WordPress.  
2. Ative o plugin no menu **Plugins**.  
3. Vá até **Configurações > Heart LinkedIn** e insira seu token de integração.  
4. No editor de blocos, insira o bloco **Heart LinkedIn**.  
5. Configure os campos personalizados do post (`likes`, `in_post`) conforme necessário.

---

## Requisitos

- WordPress 6.0 ou superior  
- ACF (Advanced Custom Fields) instalado e configurado  
- Campo ACF do tipo **Relacionamento** chamado `likes` no usuário  
- Campo ACF de texto chamado `in_post` nos posts (opcional)

---

## Uso via Shortcode

Você pode usar o plugin também via shortcode:

```php
echo do_shortcode('[heart_linkedin]');
```

---

## Estrutura

```
heart-linkedin/
├── assets/
│   ├── css/
│   │   └── heart-linkedin.css
│   └── js/
│       └── heart-linkedin.js
├── includes/
│   ├── admin-settings.php
│   ├── rest-api.php
├── heart-linkedin.php
└── README.md
```

---

## Segurança

- O plugin utiliza `nonce` e `token` para proteger requisições REST.  
- Os dados são tratados e validados antes de qualquer operação no banco.

---

## Contribuições

Contribuições são bem-vindas via pull request, fork ou sugestões.  
Este projeto segue as PSRs do PHP e as boas práticas da comunidade WordPress.

---

## Licença

Este plugin está licenciado sob a GPLv2 ou posterior.

---

## Desenvolvido por

**Rafy**  
[rafy.com.br](https://rafy.com.br) • [GitHub](https://github.com/RafyWP) • [Contato](https://rafy.com.br/contato)
