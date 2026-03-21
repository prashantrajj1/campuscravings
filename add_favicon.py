import glob

files = glob.glob('*.php') + glob.glob('*.html')
favicon_tag = '<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">'

for f in files:
    with open(f, 'r') as file:
        content = file.read()
    
    if favicon_tag not in content and '</head>' in content:
        content = content.replace('</head>', f'    {favicon_tag}\n</head>')
        with open(f, 'w') as file:
            file.write(content)
        print(f"Added favicon to {f}")
