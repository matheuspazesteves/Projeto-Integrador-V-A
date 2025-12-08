import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:path/path.dart' as p;
import 'package:sqflite/sqflite.dart';

void main() => runApp(ContactsApp());

class ContactsApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Contatos',
      theme: ThemeData(primarySwatch: Colors.blue),
      home: ContactListPage(),
    );
  }
}

/* --- Database helper --- */
class DBHelper {
  static Database? _db;

  static Future<Database> get db async {
    if (_db != null) return _db!;
    _db = await initDb();
    return _db!;
  }

  static Future<Database> initDb() async {
    final databasesPath = await getDatabasesPath();
    final path = p.join(databasesPath, 'contacts.db'); // <-- uso de p.join

    return await openDatabase(path, version: 1, onCreate: (db, version) async {
      await db.execute('''
        CREATE TABLE contacts (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          name TEXT NOT NULL,
          phone TEXT,
          email TEXT
        )
      ''');
    });
  }

  static Future<int> insert(Map<String, dynamic> row) async {
    final dbClient = await db;
    return await dbClient.insert('contacts', row);
  }

  static Future<List<Map<String, dynamic>>> getAll() async {
    final dbClient = await db;
    return await dbClient.query('contacts', orderBy: 'name COLLATE NOCASE ASC');
  }

  static Future<int> update(int id, Map<String, dynamic> row) async {
    final dbClient = await db;
    return await dbClient.update('contacts', row, where: 'id = ?', whereArgs: [id]);
  }

  static Future<int> delete(int id) async {
    final dbClient = await db;
    return await dbClient.delete('contacts', where: 'id = ?', whereArgs: [id]);
  }
}

/* --- Pages --- */

class ContactListPage extends StatefulWidget {
  @override
  _ContactListPageState createState() => _ContactListPageState();
}

class _ContactListPageState extends State<ContactListPage> {
  List<Map<String, dynamic>> contacts = [];

  @override
  void initState() {
    super.initState();
    loadContacts();
  }

  Future<void> loadContacts() async {
    final rows = await DBHelper.getAll();
    setState(() => contacts = rows);
  }

  Future<void> confirmDelete(int id) async {
    final result = await showDialog<bool>(
      context: context,
      builder: (_) => AlertDialog(
        title: Text('Confirmar exclusão'),
        content: Text('Deseja excluir este contato?'),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context, false), child: Text('Cancelar')),
          TextButton(onPressed: () => Navigator.pop(context, true), child: Text('Excluir')),
        ],
      ),
    );
    if (result == true) {
      await DBHelper.delete(id);
      await loadContacts();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Contatos')),
      body: ListView.builder(
        itemCount: contacts.length,
        itemBuilder: (_, i) {
          final c = contacts[i];
          return ListTile(
            title: Text(c['name'] ?? ''),
            subtitle: Text(c['phone'] ?? ''),
            onTap: () async {
              await Navigator.push(context,
                  MaterialPageRoute(builder: (_) => ContactDetailPage(contact: c)));
              await loadContacts();
            },
            trailing: IconButton(
              icon: Icon(Icons.delete),
              onPressed: () => confirmDelete(c['id']),
            ),
          );
        },
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () async {
          await Navigator.push(context, MaterialPageRoute(builder: (_) => AddEditPage()));
          await loadContacts();
        },
        child: Icon(Icons.add),
      ),
    );
  }
}

class ContactDetailPage extends StatelessWidget {
  final Map<String, dynamic> contact;
  ContactDetailPage({required this.contact});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Detalhes')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Text(contact['name'] ?? '', style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
          SizedBox(height: 8),
          Text('Telefone: ${contact['phone'] ?? '-'}'),
          SizedBox(height: 8),
          Text('E-mail: ${contact['email'] ?? '-'}'),
          Spacer(),
          Row(children: [
            ElevatedButton.icon(
              icon: Icon(Icons.edit),
              label: Text('Editar'),
              onPressed: () async {
                await Navigator.push(context, MaterialPageRoute(builder: (_) => AddEditPage(contact: contact)));
                Navigator.pop(context); // volta para lista
              },
            ),
            SizedBox(width: 16),
            ElevatedButton.icon(
              icon: Icon(Icons.delete),
              style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
              label: Text('Excluir'),
              onPressed: () async {
                final confirmed = await showDialog<bool>(
                  context: context,
                  builder: (_) => AlertDialog(
                    title: Text('Confirmar exclusão'),
                    content: Text('Deseja excluir este contato?'),
                    actions: [
                      TextButton(onPressed: () => Navigator.pop(context, false), child: Text('Cancelar')),
                      TextButton(onPressed: () => Navigator.pop(context, true), child: Text('Excluir')),
                    ],
                  ),
                );
                if (confirmed == true) {
                  await DBHelper.delete(contact['id']);
                  Navigator.pop(context);
                }
              },
            )
          ])
        ]),
      ),
    );
  }
}

class AddEditPage extends StatefulWidget {
  final Map<String, dynamic>? contact;
  AddEditPage({this.contact});
  @override
  _AddEditPageState createState() => _AddEditPageState();
}

class _AddEditPageState extends State<AddEditPage> {
  final _formKey = GlobalKey<FormState>();
  late TextEditingController _nameController, _phoneController, _emailController;

  // Regex simples para validar e-mail
  final RegExp _emailRegExp = RegExp(r'^[\w\.\-]+@[\w\.\-]+\.\w+$');
  // Telefone: apenas dígitos (você pode ajustar para permitir +, espaços, parênteses, etc.)
  final RegExp _phoneRegExp = RegExp(r'^\d+$');

  @override
  void initState() {
    super.initState();
    _nameController = TextEditingController(text: widget.contact?['name'] ?? '');
    _phoneController = TextEditingController(text: widget.contact?['phone'] ?? '');
    _emailController = TextEditingController(text: widget.contact?['email'] ?? '');
  }

  Future<void> save() async {
    if (!_formKey.currentState!.validate()) return;

    final row = {
      'name': _nameController.text.trim(),
      'phone': _phoneController.text.trim(),
      'email': _emailController.text.trim(),
    };

    if (widget.contact == null) {
      await DBHelper.insert(row);
    } else {
      await DBHelper.update(widget.contact!['id'], row);
    }
    Navigator.pop(context);
  }

  String? _validateName(String? v) {
    if (v == null || v.trim().isEmpty) return 'Informe o nome';
    if (v.trim().length < 2) return 'Nome muito curto';
    return null;
  }

  String? _validatePhone(String? v) {
    if (v == null || v.trim().isEmpty) return null; // telefone opcional? se quiser obrigar, mude aqui
    final s = v.trim();
    if (!_phoneRegExp.hasMatch(s)) return 'Telefone deve conter apenas números';
    if (s.length < 6 || s.length > 15) return 'Telefone com tamanho inválido';
    return null;
  }

  String? _validateEmail(String? v) {
    if (v == null || v.trim().isEmpty) return null; // e-mail opcional? se quiser obrigar, mude aqui
    final s = v.trim();
    if (!_emailRegExp.hasMatch(s)) return 'E-mail inválido';
    return null;
  }

  @override
  Widget build(BuildContext context) {
    final isEdit = widget.contact != null;
    return Scaffold(
      appBar: AppBar(title: Text(isEdit ? 'Editar Contato' : 'Novo Contato')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(children: [
            TextFormField(
              controller: _nameController,
              decoration: InputDecoration(labelText: 'Nome'),
              validator: _validateName,
              textCapitalization: TextCapitalization.words,
            ),
            TextFormField(
              controller: _phoneController,
              decoration: InputDecoration(labelText: 'Telefone', hintText: 'Apenas números'),
              keyboardType: TextInputType.phone,
              inputFormatters: [
                FilteringTextInputFormatter.digitsOnly, // bloqueia não-dígitos
              ],
              validator: _validatePhone,
            ),
            TextFormField(
              controller: _emailController,
              decoration: InputDecoration(labelText: 'E-mail'),
              keyboardType: TextInputType.emailAddress,
              autocorrect: false,
              autofillHints: [AutofillHints.email],
              validator: _validateEmail,
            ),
            SizedBox(height: 20),
            ElevatedButton(onPressed: save, child: Text('Salvar'))
          ]),
        ),
      ),
    );
  }
}
