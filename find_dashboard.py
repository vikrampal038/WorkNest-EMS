import os

with open(r'c:\Users\vikra\OneDrive\Desktop\All Projects\WorkNest-EMS\resources\views\pages\home.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, line in enumerate(lines):
    if 'dashboard' in line.lower():
        print(f"Line {i+1}: {line.strip()}")
