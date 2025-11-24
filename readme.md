# Conway’s Game of Life (PHP Implementation)

This project is a simple terminal-based simulation of [**Conway’s Game of Life**](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life), written in PHP.  
It creates a grid, seeds it with a classic **Glider** pattern, and animates the simulation in your console.

---

## Features

- Pure PHP implementation — no external libraries
- Toroidal (wrapping) grid
- Real-time terminal animation
- Adjustable grid size
- Easy to add your own patterns

---

Output Example

Live cells render as `*`, dead cells as `.`:

```
.....*....
......*...
....***...
..........
..........
```

---

## Requirements

- **PHP 7.4+**
- Terminal with ANSI escape sequence support

---

## Running the Simulation

Clone the repository:

```bash
git clone https://github.com/roberiacono/game-of-life-php.git
cd your-repo
php index.php
```
