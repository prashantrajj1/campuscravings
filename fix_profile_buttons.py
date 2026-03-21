import re

# 1. Strip the inline <style> block from profile.php and ensure css/profile.css is properly linked
with open('profile.php', 'r') as f:
    c = f.read()

c = re.sub(r'<style>[\s\S]*?</style>', '    <link rel="stylesheet" href="css/profile.css">', c)

with open('profile.php', 'w') as f:
    f.write(c)
print("Stripped style block from profile.php")

# 2. Update css/profile.css to make .profile-avatar smaller, and align button styles
with open('css/profile.css', 'r') as f:
    css = f.read()

# Update .profile-avatar to be purely circular and smaller
css = re.sub(
    r'\.profile-avatar \{[^}]+\}',
    r'.profile-avatar { width: 70px; height: 70px; background: #fc8019; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: #fff; box-shadow: 0 4px 10px rgba(252, 128, 25, 0.2); overflow: hidden; flex-shrink: 0; }',
    css
)

# Replace old .back-link and .btn-logout definitions
css = re.sub(r'\.back-link \{[^}]+\}\n?', '', css)
css = re.sub(r'\.btn-logout \{[^}]+\}\n?', '', css)
css = re.sub(r'\.btn-submit \{[^}]+\}\n?', '', css)
css = re.sub(r'\.btn-submit:hover \{[^}]+\}\n?', '', css)

button_styles = """
.btn-submit, .btn-logout, .back-link {
    background: orange;
    color: #fff !important;
    border: none;
    padding: 16px;
    border-radius: 10px;
    font-weight: 800;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: background 0.3s;
    text-decoration: none;
    display: inline-block;
    box-sizing: border-box;
    text-align: center;
}
.btn-submit:hover, .btn-logout:hover, .back-link:hover {
    background: darkorange;
}
.btn-submit, .btn-logout {
    width: 100%;
}
.back-link {
    padding: 10px 15px; 
    width: auto;
}
"""

css += button_styles

with open('css/profile.css', 'w') as f:
    f.write(css)
print("Updated css/profile.css styling rules")
