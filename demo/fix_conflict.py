import re
import sys

filename = 'c:/Users/analistadedatos/Documents/Vladimir/ListoEnLinea/demo/index.html'

with open(filename, 'r', encoding='utf-8') as f:
    content = f.read()

# Fix the missing > on the button
content = re.sub(
    r'(onclick="downloadExcelReport\(\'reporte_facturas_demo\.xlsx\', \'Reporte de facturas\', window\.currentInvoiceRows, \'invoiceChart\'\)")\s*?(<i class="bi bi-download">)',
    r'\1>\n                        \2',
    content
)

# Resolve conflict
conflict_pattern = re.compile(
    r'<<<<<<< HEAD:demo/index\.html\n.*?\n=======\n(.*?)\n>>>>>>> a349e0dcc05e77be555a0ca322ebded0304e0bdc:demo\.html\n?',
    re.DOTALL
)

def replacer(match):
    incoming = match.group(1)
    # the incoming change changed `../assets` to `assets`, we need to revert that because we are in demo/
    incoming = incoming.replace('src="assets/', 'src="../assets/')
    return incoming

content = conflict_pattern.sub(replacer, content)

with open(filename, 'w', encoding='utf-8') as f:
    f.write(content)

print("File fixed.")
