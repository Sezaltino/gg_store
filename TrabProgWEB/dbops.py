import hashlib
import math
import random
import string
import mysql.connector
from datetime import date

mydb = mysql.connector.connect(
  host="localhost",
  port= 3306,
  password="1234",
  user="gabri",
  database = "gg_store"
)
mycursor = mydb.cursor()

def criar_balanco(email):
    sql2 = "select id_users from users where email=%s"
    format_list = [email]
    mycursor.execute(sql2, tuple(format_list))
    resultado = mycursor.fetchall()

    sql3 = "insert into balancos(fk_users, saldo) values (%s, 0.0)"
    format_list2 = [resultado[0][0]]
    mycursor.execute(sql3, format_list2)
    mydb.commit()

def registo(datas):
    #Criação de caracteres diversos para criar o salt em seguida
    caracteres = string.ascii_letters+string.digits+string.punctuation
    #Criação do salt para a criação da password, essa criação é feita escolhendo 16 caracteres aleatórios da variavel acima
    #salt = ''.join(random.choices(caracteres, k=16))
    salt = ''.join(random.choices(caracteres, k=16))
    #Em seguida é criado o hash que é a junção da password inserida pelo user com o salt a formar um string composta, em seguida é feito a encriptação 
    hash = hashlib.sha256((str(salt)+str(datas[2].unescape())).encode(encoding= 'UTF-8'))

    User = { "nome": datas[0].unescape(),
    "email": datas[1].unescape(),
    "hash" : str(hash.digest()),
    "salt" : salt
    }
    
    if len(datas) == 3:
        data_formated = []

        for values in User.values():
            data_formated.append(values)

        data_formated = tuple(data_formated)

        sql = "INSERT INTO users (nome, email, password, salt) VALUES (%s, %s, %s, %s)"

    try:
        mycursor.execute(sql,data_formated)
        mydb.commit()
        criar_balanco(User["email"])
        return False, "Usuário Registado"
    
    except Exception as e:
        return True, "Email já existe"


def login(datas):
    sql = "SELECT * FROM users WHERE email = %s"
    lista= [datas[0].unescape()]
    mycursor.execute(sql,tuple(lista))
    resultado = mycursor.fetchall()

    sql = "SELECT * FROM editoras WHERE email = %s"
    lista1= [datas[0].unescape()]
    mycursor.execute(sql,tuple(lista1))
    resultado1 = mycursor.fetchall()

    print(len(resultado))
    print(len(resultado1))

    #para um user
    if len(resultado) > 0:
        user = list(resultado[0])

        User = {"id": user[0],
                "nome":user[1],
                "email":user[2],
                "password":user[3],
                "salt":user[4],
                "role": "user"}
       
        hash = hashlib.sha256((str(User["salt"])+str(datas[1].unescape())).encode(encoding= 'UTF-8'))


        if str(User["password"]) == str(hash.digest()):

            return True, User

        else:
            User = {"void"}
            return False, User
    #para um developer
    elif len(resultado1) > 0:
        user = list(resultado1[0])

        User = {"id": user[0],
                "nome":user[1],
                "email":user[2],
                "password":user[3],
                "salt":user[4],
                "role": "dev"}
       
        hash = hashlib.sha256((str(User["salt"])+str(datas[1].unescape())).encode(encoding= 'UTF-8'))

        if str(User["password"]) == str(hash.digest()):

            return True, User
        else:
            User = {"void"}
            return False, User
    else:
        return False, User

def ler_games(page):   
    sql = "select count(ID_games) from games"
    mycursor.execute(sql)
    resultado=mycursor.fetchall()
    calc = math.ceil(resultado[0][0]/15)
    init = (resultado[0][0]/calc)*page
    final= (resultado[0][0]/calc)*(page+1)
    sql1= "select * from games limit %s, %s"
    mycursor.execute(sql1, (math.ceil(init), math.ceil(final)))
    resultado1 = mycursor.fetchall()

    return resultado1, calc

def ler_saldo(id_users):   
    sql = "select saldo from balancos where fk_users = %s"
    tuple1 = [id_users]
    mycursor.execute(sql, tuple(tuple1))
    resultado = mycursor.fetchall()

    return resultado

def comprar_jogo(id_users, id_games):   
    sql = "select PriceFinal from games where ID_games = %s"
    lista = [id_games]
    mycursor.execute(sql, tuple(lista))
    resultado = mycursor.fetchall()
    valor_jogo = float(resultado[0][0])

    sql = "select saldo from balancos where fk_users = %s"
    lista1 = [id_users]
    mycursor.execute(sql, tuple(lista1))
    resultado = mycursor.fetchall()
    saldo = float(resultado[0][0])

    if saldo >= valor_jogo:
        sql = "insert into transacoes(fk_users, fk_games, data, valor) values (%s,%s,%s,%s)"
        format_list = [id_users, id_games, "2022-12-25", valor_jogo]
        mycursor.execute(sql, tuple(format_list))

        valor_final = saldo-valor_jogo

        sql = "update balancos set saldo = %s where fk_users = %s"
        format_list1 = [valor_final, id_users]
        mycursor.execute(sql, tuple(format_list1))

        mydb.commit()

def inserir_comentario(id_users, id_games, comentario, avaliacao):
    sql = "insert into comentarios(fk_users, fk_games, comentario, data, avaliacao) values (%s, %s, %s, %s, %s)"
    today = date.today()
    format_list = [id_users, id_games, comentario, today, avaliacao]
    mycursor.execute(sql, tuple(format_list))
    mydb.commit()

def editar_comentario(id_users, id_games, comentario):  
    sql = "update comentarios set comentario = %s where fk_users= %s and fk_games = %s"
    format_list = [comentario, id_users, id_games]
    mycursor.execute(sql, tuple(format_list))
    mydb.commit()

def delete_comentario(id_users, id_games):   
    sql = "delete from comentarios where fk_users= %s and fk_games = %s"
    format_list = [id_users, id_games]
    mycursor.execute(sql, tuple(format_list))
    mydb.commit()

def ler_game(id_games):
    sql = "select games.queryname, games.pricefinal, group_concat(comentarios.comentario), (sum(comentarios.avaliacao)/count(comentarios.avaliacao)), group_concat(users.nome) from ((games inner join comentarios on games.id_games = comentarios.fk_games) inner join users on comentarios.fk_users = users.id_users) where games.id_games = %s"
    format_list = [id_games]
    mycursor.execute(sql, tuple(format_list))
    resultado = mycursor.fetchall()
    #return type list
    return resultado

