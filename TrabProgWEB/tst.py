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
  database="gg_store"
)


mycursor = mydb.cursor()
mycursor1 = mydb.cursor()

def criar_tables():

  sql = "select count(id_games) from games"
  mycursor.execute(sql)
  resultado=mycursor.fetchall()
  limit = (resultado[0][0]/5)*4
  limit1 = (resultado[0][0]/5)*5
  sql1= "select * from games limit %s, %s"
  mycursor1.execute(sql1, (int(limit), int(limit1)))
  resultado1 = mycursor1.fetchall()
  wtf = []
  for a in range(0, 85):
    wtf = list(resultado1[a])
    wtf[34] = 7
    resultado1[a] = tuple(wtf)
    wtf = []
  #85 85 85 85 85 


  print(resultado1[60][34])
  for a in range(0, len(resultado1)):
    sql = "update games set fk_editoras = %s where ID_games = %s"
    mycursor.execute(sql, (resultado1[a][34], resultado1[a][0]))
    mydb.commit()

def criar_tables2():

  sql = "CREATE TABLE comentarios (id INT AUTO_INCREMENT PRIMARY KEY, fk_users int, fk_games int, comentario varchar(500), data date, avaliacao float)"
  text = ["JOGO BOM DEMAIS PQP", "2022-12-29"]
  sql2= "insert into comentarios (fk_users, fk_games, comentario, data , avaliacao) values (4, 10, %s, %s, 5)"
  mycursor.execute(sql2, tuple(text))
  mydb.commit()

def cenas(page):

  sql = "select count(id_games) from games"
  mycursor.execute(sql)
  resultado=mycursor.fetchall()
  calc = math.ceil(resultado[0][0]/15)
  init = (resultado[0][0]/calc)*page
  final= (resultado[0][0]/calc)*(page+1)
  sql1= "select * from games limit %s, %s"
  mycursor.execute(sql1, (math.ceil(init), math.ceil(final)))
  resultado1 = mycursor.fetchall()
  print(resultado1)

def ler_saldo(id_user):
  sql = "select saldo from balancos where fk_users = %s"
  tuple1 = [id_user]
  mycursor.execute(sql, tuple(tuple1))
  resultado = mycursor.fetchall()
  print(resultado)

def comprar_jogo(id_user, id_jogo):
  sql = "select PriceFinal from games where ID_games = %s"
  lista = [id_jogo]
  mycursor.execute(sql, tuple(lista))
  resultado = mycursor.fetchall()
  valor_jogo = float(resultado[0][0])

  sql = "select saldo from balancos where fk_users = %s"
  lista1 = [id_user]
  mycursor.execute(sql, tuple(lista1))
  resultado = mycursor.fetchall()
  saldo = float(resultado[0][0])

  if saldo >= valor_jogo:
    sql = "insert into transacoes(fk_users, fk_games, data, valor) values (%s,%s,%s,%s)"
    format_list = [id_user, id_jogo, "2022-12-25", valor_jogo]
    mycursor.execute(sql, tuple(format_list))

    valor_final = saldo-valor_jogo

    sql = "update balancos set saldo = %s where fk_users = %s"
    format_list1 = [valor_final, id_user]
    mycursor.execute(sql, tuple(format_list1))

    mydb.commit()


def inserir_comentario(id_users, id_games, comentario, data, avaliacao):
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

def select_game(id_games):
  sql = "select games.queryname, games.pricefinal, group_concat(comentarios.comentario), (sum(comentarios.avaliacao)/count(comentarios.avaliacao)), group_concat(users.nome) from ((games inner join comentarios on games.id_games = comentarios.fk_games) inner join users on comentarios.fk_users = users.id_users) where games.id_games = %s"
  format_list = [id_games]
  mycursor.execute(sql, tuple(format_list))
  resultado = mycursor.fetchall()
  print(resultado)

def criar_balanco(email):
  sql2 = "select id_users from users where email=%s"
  format_list = [email]
  mycursor.execute(sql2, tuple(format_list))
  resultado = mycursor.fetchall()

  sql3 = "insert into balancos(fk_users, saldo) values (%s, 0.0)"
  format_list2 = [resultado[0][0]]
  mycursor.execute(sql3, format_list2)
  mydb.commit()

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

        User = {"id_users": user[0],
                "nome":user[1],
                "email":user[2],
                "password":user[3],
                "salt":user[4]}
       
        hash = hashlib.sha256((str(User["salt"])+str(datas[1].unescape())).encode(encoding= 'UTF-8'))


        if str(User["password"]) == str(hash.digest()):

            return True, User

        else:
            User = {"void"}
            return False, User
    #para um developer
    elif len(resultado1) > 0:
        user = list(resultado[0])

        User = {"id_editoras": user[0],
                "nome":user[1],
                "email":user[2],
                "password":user[3],
                "salt":user[4]}
       
        hash = hashlib.sha256((str(User["salt"])+str(datas[1].unescape())).encode(encoding= 'UTF-8'))

        if str(User["password"]) == str(hash.digest()):

            return True, User
        else:
            User = {"void"}
            return False, User
    else:
        return False, User
#criar_balanco("gabrielsezaltino@hotmail.com")
#inserir_comentario(2, 20, "Jogo mais ou menos", "2022-12-30", 2)
#select_game(10)
datas = ["arroz"]
login(datas)


#print("Today date is: ", type(today))


