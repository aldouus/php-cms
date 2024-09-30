import { useState, useEffect } from 'react';

export const EditableText = () => {
  const [text, setText] = useState('');
  const [isEditing, setIsEditing] = useState(false);

  useEffect(() => {
    const fetchText = async () => {
      const response = await fetch('http://localhost:8000');
      const data = await response.json();
      setText(data.text);
    };
    fetchText();
  }, []);

  const saveText = async () => {
    await fetch('http://localhost:8000', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ text }),
    });
    setIsEditing(false);
  };

  const handleEdit = () => setIsEditing(true);

  const handleInputChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
    setText(e.target.value);
  };

  return (
    <div>
      {isEditing ? (
        <>
          <textarea value={text} onChange={handleInputChange} />
          <button type='button' onClick={saveText}>Save</button>
        </>
      ) : (
        <>
          <p>{text}</p>
          <button type='button' onClick={handleEdit}>Edit</button>
        </>
      )}
    </div>
  );
};
