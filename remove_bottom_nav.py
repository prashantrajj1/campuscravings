import os
import glob
import re

files = glob.glob('*.php')

for f in files:
    with open(f, 'r') as file:
        content = file.read()
    
    # Regex to catch <nav class="bottom-nav"> ... </nav> block
    new_content = re.sub(r'<nav class="bottom-nav"[\s\S]*?</nav>', '', content)
    
    if new_content != content:
        with open(f, 'w') as file:
            file.write(new_content)
        print(f"Removed bottom-nav from {f}")
