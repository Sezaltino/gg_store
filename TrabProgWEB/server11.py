import hashlib
import random
import string
from flask import Flask, render_template, Response, request, redirect, session, url_for, jsonify
from flask_sqlalchemy import SQLAlchemy
from markupsafe import escape

#inicialização do sqlalchemy
db = SQLAlchemy()

#inicialização do flask
app = Flask(__name__)

#criação da secret key pra session 
app.secret_key = b'((s23e__#i54e/*!'

#configuração da base de dados 
app.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///Usuarios.db"
db.init_app(app)

#classe com os campos da base de dados 
class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nome = db.Column(db.String(50))
    email = db.Column(db.String(50), unique=True)
    salt = db.Column(db.String(50))
    password = db.Column(db.String(50))

#criação da base de dados, caso já exista não efetua a criação 
with app.app_context():
    db.create_all()
    

#Rota padrão, caso exista uma session open e com o campo email ele retorta a pagina com o conteudo, ou seja ele loga o usuário
#Se não exister uma session open ele redireciona para o 'login'
@app.route('/')
def index():

    if 'email' in session:
        return render_template('index.html')

    else:
        return redirect(url_for('login'))


"""Rota de logout, se tiver uma session open ele limpa a session e retonar pra "/" que automaticamente
leva para a pagina de login, isso foi feito para garantir que o usuário não está logado """
@app.route('/logout')
def logout():

    if 'email' in session:

        session.clear()
        return redirect('/')


#Rota do login
@app.route('/login', methods = ['GET', 'POST'])
def login():

    if request.method == 'POST':
        
        #obtém o email do user
        email = escape(request.form['email'])
        #obtém a password do user 
        password = escape(request.form['password'])

        #Try para tentar pegar o valor da checkbox, realizei esse Try devido ao erro que ele gera caso a checkbox não está selecionada
        try:
            #Caso o user selecione a checkbox ele retorna o valor de "on"
            checkbox = request.form['checkbox1']

            #Em seguida ele define a variável checkbox=True
            if checkbox == "on":
                checkbox = True

        #Se der erro, ou seja a checkbox não foi selecionada e não retornou valor ele devine a variável checkbox = False
        except: 
            checkbox = False

        #query da base de dados user com filter_by, ou seja se o email inserido pelo User existir é feito a seleção do elemento na base de dados e envia para a variável "user" 
        user = User.query.filter_by(email=email).first()


        if user:
            #Se o user existir na base de dados ele cria um hash com o salt que está na base de dados e com a password inserida pelo usuário e faz o encode
            hash = hashlib.sha256((str(user.salt)+str(password)).encode(encoding='UTF-8'))

            #Em seguida ele compara a password que está na base de dados (password + salt encriptada) com o hash criado da password inserida pelo user.
            if user.password == hash.digest():

            #Se for igual ele cria a session de email e nome, por conta do nome poder estar repitido(sendo que pessoas podem ter o mesmo nome) e o email ser a variável unique da base de dados
                session['email'] = user.email
                session['nome'] = user.nome

                #Caso o user tenha selecionado a checkbox a session fica permanent, ou seja, sempre que o user entrar no site a sessão permanecerá ao menos que ele clique em logout 
                if checkbox == True:
                    session.permanent = True

                #Retorna ao index com a session criada
                return redirect(url_for('index'))


            else:
                #Caso a comparação da senha esteja errada ele retorna ao login e envia a mensagem = "Senha Inválida"
                return render_template('login.html', div = "Senha inválida!")

        else:
            #Caso a query com o filter by não encontre o email ele retorna ao login com a mensagem = "Esse email não está cadastrado"
            return render_template('login.html', div = "Esse email não está cadastrado!")

    return render_template('login.html', local_ip="127.0.0.1")

#Rota de Registo 
@app.route('/register', methods = ['GET', 'POST'])
def register():
    if request.method == 'POST':
        #Try para verificar se o email inserido no registo já existe na base de dados, caso exista na linha 137 quando for efetuado o commit da session da base de dados é gerado um erro 
        try:
            #Criação de caracteres diversos para criar o salt em seguida
            caracteres = string.ascii_letters+string.digits+string.punctuation
            #Criação do salt para a criação da password, essa criação é feita escolhendo 16 caracteres aleatórios da variavel acima
            salt = ''.join(random.choices(caracteres, k=16))
            password = escape(request.form['password'])
            #Em seguida é criado o hash que é a junção da password inserida pelo user com o salt a formar um string composta, em seguida é feito a encriptação 
            hash = hashlib.sha256((str(salt)+str(password)).encode(encoding= 'UTF-8'))

            #Criação do user na base de dados
            #É importante deixar claro que é necessario o armazenamento do salt para conseguir no login fazer a autenticação do usuário
            user = User(
            email = escape(request.form['email']),
            nome = escape(request.form['nome']),
            salt = str(salt),
            password = hash.digest())

            #Adiciona o usuario na sessão da base de dados 
            db.session.add(user)
            #Realiza o commit 
            db.session.commit()      
            return render_template('login.html')
            
        except Exception as e:
           
           #Caso o email que o usuario colocou no registo na exista ele irá dar um erro com o code abaixo
            if e.code == "gkpj":
                #Caso o erro seja mesmo no email ele returna o user de volta para o email com a seguinte mensagem = "Email já existe"
                if str(e.orig) == "UNIQUE constraint failed: user.email":
                    return render_template('register.html', div = "Email já existe!!")
   
    return render_template('register.html')

if __name__ == "__main__": 
    app.run(debug=True, ssl_context=('localhost.crt', 'localhost.key'))
    #app.run()
