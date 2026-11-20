<style>
  .tools { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; margin-bottom: 2.5rem; }
  .chips { display: flex; gap: .4rem; }
  .chips button { min-height: 40px; padding: .4rem .9rem; font: inherit; font-weight: 700; font-size: .75rem; letter-spacing: .12em; text-transform: uppercase; font-variation-settings: "wdth" 78; background: transparent; color: var(--sc-ink-soft); border: 1px solid rgb(255 255 255 / .25); cursor: pointer; }
  .chips button[aria-pressed="true"] { background: var(--white); color: var(--ink); border-color: var(--white); }
  .search { margin-left: auto; display: flex; align-items: center; gap: .5rem; border-bottom: 2px solid rgb(255 255 255 / .5); min-width: 18rem; }
  .search input { background: transparent; border: 0; color: var(--white); font: inherit; padding: .6rem 0; width: 100%; }
  .search input::placeholder { color: var(--sc-ink-soft); }
  /* Forms as filed sheets: each one a copy with its stamp. */
  .drawer { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 2.5rem 2rem; list-style: none; padding: 0; margin: 0; }
  .card { padding: 1.75rem 1.75rem 0; min-height: 17rem; display: flex; flex-direction: column; transform: rotate(var(--tilt, 0deg)); transition: transform 220ms ease-out; }
  .card:hover { transform: rotate(0deg) translateY(-4px); }
  .card h3 { margin: .5rem 0 .4rem; font-size: 1.55rem; font-weight: 750; font-variation-settings: "wdth" 110; letter-spacing: -.01em; line-height: 1.05; max-width: 14ch; }
  .card h3 a { text-decoration: none; }
  .card h3 a::after { content: ""; position: absolute; inset: 0; }
  .card .stamp { position: absolute; right: 1.5rem; top: 3.25rem; font-size: 1rem; }
  .card dl { display: grid; grid-template-columns: auto auto; justify-content: start; gap: .2rem 1.5rem; margin: auto 0 1.25rem; font-size: .92rem; }
  .card dt { color: var(--ink-2); font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; font-weight: 700; font-variation-settings: "wdth" 72; }
  .card dd { margin: 0; font-weight: 700; }
  .card .foot { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; gap: .5rem; padding: .9rem 0 1rem; border-top: 1px dashed var(--rule); font-size: .85rem; }
  .card .foot code { color: var(--pen); font: inherit; }
  .new { border: 2px dashed rgb(255 255 255 / .35); display: grid; place-content: center; text-align: center; gap: .75rem; min-height: 17rem; padding: 2rem; color: var(--sc-ink-soft); }
  .new b { color: var(--white); font-size: 1.1rem; }
  @media (max-width: 1000px) { .drawer { grid-template-columns: 1fr 1fr; } }
  @media (max-width: 640px) { .drawer { grid-template-columns: 1fr; } .wrap { padding-inline: 1rem; } .topbar { padding: 0 1rem; } .nav { display: none; } }
  @media (max-width: 640px) {
    .chips, .card .foot { flex-wrap: wrap; }
    .search { margin-left: 0; min-width: 0; width: 100%; }
    .card { transform: none; }
    .card .stamp { position: static; align-self: start; margin: .5rem 0 1rem; }
  }
</style>
