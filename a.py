def depiler(pile):
    return pile.pop()

def empiler(pile, e):
    pile.append(e)

def deplacer(pile_source, pile_cible):
    element = depiler(pile_source)
    empiler(pile_cible, element)
    print("Déplacer le disque", element, "de", pile_source, "vers", pile_cible)

def est_vide(p):
    return len(p) == 0

def c_pile():
    return []

def initialisation(pileA, NBR_DISQUES):
    for i in range(NBR_DISQUES, 0, -1):
        empiler(pileA, i)

def hanoi(n, pile_source, pile_cible, pile_auxiliaire):
    if n > 0:
        hanoi(n - 1, pile_source, pile_auxiliaire, pile_cible)
        deplacer(pile_source, pile_cible)
        hanoi(n - 1, pile_auxiliaire, pile_cible, pile_source)

pileA = c_pile()
pileB = c_pile()
pileC = c_pile()

NBR_DISQUES = int(input("Combien de disques voulez-vous ? "))

initialisation(pileA, NBR_DISQUES)

print("État initial des piles:")
print("Pile A:", pileA)
print("Pile B:", pileB)
print("Pile C:", pileC)

hanoi(NBR_DISQUES, pileA, pileC, pileB)

print("\nÉtat final des piles:")
print("Pile A:", pileA)
print("Pile B:", pileB)
print("Pile C:", pileC)
