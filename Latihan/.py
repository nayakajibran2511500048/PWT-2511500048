import pygame
import sys

# Inisialisasi pygame
pygame.init()

# Ukuran layar
width, height = 800, 600
screen = pygame.display.set_mode((width, height))
pygame.display.set_caption("Animasi Bola Memantul")

# Warna
white = (255, 255, 255)
blue = (0, 100, 255)

# Properti bola
x, y = 100, 100
radius = 20
dx, dy = 5, 5  # kecepatan

clock = pygame.time.Clock()

# Loop utama
while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            sys.exit()

    # Gerakan bola
    x += dx
    y += dy

    # Pantulan dinding
    if x - radius <= 0 or x + radius >= width:
        dx *= -1
    if y - radius <= 0 or y + radius >= height:
        dy *= -1

    # Gambar ulang layar
    screen.fill(white)
    pygame.draw.circle(screen, blue, (x, y), radius)

    pygame.display.update()
    clock.tick(60)  # FPS
